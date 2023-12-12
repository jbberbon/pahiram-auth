<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

use App\Http\Rules\ExistsInCourses;
use App\Exceptions\RequestExtraPayloadMsg;
use App\Exceptions\RequestValidationFailedMsg;


class RegisterAccountRequest extends FormRequest
{
    private $errorCode = 422;
    public function rules()
    {
        return [
            'apc_id' => 'required|string|unique:users',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'course_id' => ['required', 'string', new ExistsInCourses],
            'is_employee' => 'boolean',
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
        $message = "Registration Failed";
        $errorCode = $this->errorCode;
        RequestValidationFailedMsg::errorResponse($validator, $message, $errorCode);
    }
}
