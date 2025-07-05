<?php

namespace App\Http\Requests\Topic;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TopicCreate extends FormRequest
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
                    $exists = \App\Models\Topic::where('name', $value)
                        ->where('subject_id', $this->subject_id)
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
