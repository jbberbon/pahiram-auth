<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

use App\Exceptions\RequestExtraPayloadMsg;
use App\Exceptions\RequestValidationFailedMsg;

class AddCourseRequest extends FormRequest
{
    private $errorCode = 401;
    public function rules()
    {
        return [
            'course_code' => 'required|string|unique:courses',
            'course' => 'required|string|unique:courses',
            'course_acronym' => 'required|string',
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
        $message = "Failed to add course";
        $method = "POST";
        $errorCode = $this->errorCode;
        RequestValidationFailedMsg::errorResponse($validator, $message, $errorCode);
    }

}