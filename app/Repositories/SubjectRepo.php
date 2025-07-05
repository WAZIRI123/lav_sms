<?php

namespace App\Repositories;

use App\Models\Subject;

class SubjectRepo
{
    public function createSubject($data)
    {
        return Subject::create($data);
    }

    public function findSubject($id)
    {
        return Subject::find($id);
    }

    public function findSubjectByClass($class_id, $order_by = 'name')
    {
        return Subject::where('my_class_id', $class_id)
            ->orderBy($order_by)
            ->get();
    }

    public function updateSubject($id, $data)
    {
        return Subject::find($id)->update($data);
    }

    public function deleteSubject($id)
    {
        return Subject::destroy($id);
    }

    public function getAllSubjects()
    {
        return Subject::with('my_class')->orderBy('name')->get();
    }
}
