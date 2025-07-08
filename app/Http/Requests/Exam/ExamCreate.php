<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class ExamCreate extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'name' => 'required|string',
            'term' => [
                'required',
                'numeric',
                function ($attribute, $value, $fail) {
                    $exists = \App\Models\Exam::where('term', $value)->exists();
                    if ($exists) {
                        $fail('An exam with this term already exists.');
                    }
                },
            ],
        ];
    }

}
