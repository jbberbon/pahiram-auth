<?php

namespace App\Http\Requests;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

use App\Exceptions\RequestExtraPayloadMsg;
use App\Exceptions\RequestValidationFailedMsg;



class EditCourseRequest extends FormRequest
{
    private $errorCode = 401;
    public function rules()
    {
        return [
            'course_code' => 'string|unique:courses',
            'course' => 'string|unique:courses',
            'course_acronym' => 'string',
        ];
    }

    protected function passedValidation()
    {
        $request = $this->input();
        $rules = $this->rules();
        $errorCode = $this->errorCode;
        RequestExtraPayloadMsg::errorResponse($request, $rules, $errorCode);
    }
    protected function failedValidation(Validator $validator)
    {
        $message = "Failed to edit course";
        $method = "PATCH";
        $errorCode = $this->errorCode;
        RequestValidationFailedMsg::errorResponse($validator, $message, $errorCode);
    }
}