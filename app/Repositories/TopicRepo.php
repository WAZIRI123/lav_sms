<?php

namespace App\Repositories;

use App\Models\Topic;

class TopicRepo
{
    public function createTopic($data)
    {
        return Topic::create($data);
    }

    public function findTopic($id)
    {
        return Topic::with('subject.my_class')->find($id);
    }

    public function findTopicBySubject($subject_id, $order_by = 'name')
    {
        return $this->getTopic(['subject_id' => $subject_id])->orderBy($order_by)->get();
    }

    public function getTopic($data)
    {
        return Topic::where($data);
    }

    public function updateTopic($id, $data)
    {
        return Topic::find($id)->update($data);
    }

    public function deleteTopic($id)
    {
        return Topic::destroy($id);
    }

    public function getAllTopics()
    {
        return Topic::orderBy('name', 'asc')->with('subject.my_class')->get();
    }
}
