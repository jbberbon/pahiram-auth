<?php

namespace App\Http\Requests;

use App\Exceptions\RequestValidationFailed;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EditCourseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'course_code' => 'string|unique:courses',
            'course' => 'string|unique:courses',
            'course_acronym' => 'string',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $message = "Failed to edit course";
        $method = "PATCH";
        $errorCode = 401;
        RequestValidationFailed::errorResponse($validator, $message, $method, $errorCode);
    }
}