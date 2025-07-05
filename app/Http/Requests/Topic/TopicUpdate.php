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
            'name' => 'required|string|max:255',
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
