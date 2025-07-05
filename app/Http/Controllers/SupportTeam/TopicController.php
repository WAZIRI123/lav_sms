<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Topic\TopicCreate;
use App\Http\Requests\Topic\TopicUpdate;
use App\Models\Topic;
use App\Repositories\MyClassRepo;
use App\Repositories\SubjectRepo;
use App\Repositories\TopicRepo;

class TopicController extends Controller
{
    protected $my_class, $subject, $topic;

    public function __construct(MyClassRepo $my_class, SubjectRepo $subject, TopicRepo $topic)
    {
        $this->middleware('teamSA', ['except' => ['destroy']]);
        $this->middleware('super_admin', ['only' => ['destroy']]);

        $this->my_class = $my_class;
        $this->subject = $subject;
        $this->topic = $topic;
    }

    public function index()
    {
        $d['my_classes'] = $this->my_class->all();
        $d['topics'] = $this->topic->getAllTopics();

        return view('pages.support_team.topics.index', $d);
    }

    public function store(TopicCreate $req)
    {
        $data = $req->all();
        $this->topic->createTopic($data);

        return redirect()->route('topics.index')->with('flash_success', __('msg.store_ok'));
    }

    public function edit($topicId)
    {
        // First find the topic
        $topic = Topic::with('subject.my_class')->find($topicId);
        
        if (!$topic) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Topic not found'
                ], 404);
            }
            return Qs::goWithDanger('topics.index');
        }
        
        // For AJAX requests, return JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                't' => $topic,
                'my_classes' => $this->my_class->all(),
                'subjects' => $this->subject->findSubjectByClass($topic->subject->my_class_id)
            ]);
        }

        $d['t'] = $topic;
        $d['my_classes'] = $this->my_class->all();
        $d['subjects'] = $this->subject->findSubjectByClass($topic->subject->my_class_id);

        return view('pages.support_team.topics.edit', $d);
    }

    public function update(TopicUpdate $req, $topicId)
    {
        $topic = Topic::find($topicId);
        if (!$topic) {
            return redirect()->route('topics.index')->with('flash_danger', __('Topic not found'));
        }
        
        $data = $req->all();
        $this->topic->updateTopic($topic->id, $data);

        return redirect()->route('topics.index')->with('flash_success', __('msg.update_ok'));
    }

    public function destroy($topicId)
    {
        $topic = Topic::find($topicId);
        if (!$topic) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Topic not found'
                ], 404);
            }
            return redirect()->route('topics.index')->with('flash_danger', __('Topic not found'));
        }
        
        $this->topic->deleteTopic($topic->id);
        
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('Topic deleted successfully')
            ]);
        }
        
        return redirect()->route('topics.index')->with('flash_success', __('msg.delete_ok'));
    }

    public function getSubjectsByClass($class_id)
    {
        $subjects = $this->subject->findSubjectByClass($class_id);
        return response()->json($subjects);
    }
}
