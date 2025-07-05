<?php

namespace App\Http\Requests\Topic;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TopicUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $topicId = $this->route('topic');
                    $exists = \App\Models\Topic::where('name', $value)
                        ->where('subject_id', $this->subject_id)
                        ->where('id', '!=', $topicId)
                        ->exists();
                    
                    if ($exists) {
                        $fail('A topic with this name already exists for the selected subject.');
                    }
                },
            ],
            'competency' => 'required|string',
            'subject_id' => 'required|exists:subjects,id',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Topic Name',
            'competency' => 'Competency',
            'subject_id' => 'Subject',
        ];
    }
}
