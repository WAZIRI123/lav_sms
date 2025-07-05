<?php

namespace App\Http\Controllers\SupportTeam;

use App\Helpers\Qs;
use App\Http\Controllers\Controller;
use App\Http\Requests\Topic\TopicCreate;
use App\Http\Requests\Topic\TopicUpdate;
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

    public function edit($id)
    {
        $d['t'] = $topic = $this->topic->findTopic($id);
        $d['my_classes'] = $this->my_class->all();
        $d['subjects'] = $this->subject->findSubjectByClass($topic->subject->my_class_id);

        return is_null($topic) ? Qs::goWithDanger('topics.index') : view('pages.support_team.topics.edit', $d);
    }

    public function update(TopicUpdate $req, $id)
    {
        $data = $req->all();
        $this->topic->updateTopic($id, $data);

        return redirect()->route('topics.index')->with('flash_success', __('msg.update_ok'));
    }

    public function destroy($id)
    {
        $this->topic->deleteTopic($id);
        return redirect()->route('topics.index')->with('flash_success', __('msg.delete_ok'));
    }

    public function getSubjectsByClass($class_id)
    {
        $subjects = $this->subject->findSubjectByClass($class_id);
        return response()->json($subjects);
    }
}
