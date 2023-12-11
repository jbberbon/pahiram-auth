<?php

namespace App\Http\Requests;

use App\Exceptions\RequestValidationFailed;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;


class AddCourseRequest extends FormRequest
{
    public function rules()
    {
        return [
            'course_code' => 'required|string|unique:courses',
            'course' => 'required|string|unique:courses',
            'course_acronym' => 'required|string',
            '*' => Rule::notIn(array_keys($this->rules())),
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $message = "Failed to add course";
        $method = "POST";
        $errorCode = 401;
        RequestValidationFailed::errorResponse($validator, $message, $method, $errorCode);
    }

}