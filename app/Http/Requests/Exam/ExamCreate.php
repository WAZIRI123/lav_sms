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
                    $year = \App\Helpers\Qs::getSetting('current_session');
                    $exists = \App\Models\Exam::where('term', $value)
                        ->where('year', $year)
                        ->exists();
                    
                    if ($exists) {
                        $fail('An exam with this term already exists for the current academic year.');
                    }
                },
            ],
        ];
    }

}
