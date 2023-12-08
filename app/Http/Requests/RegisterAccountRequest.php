<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

use App\Http\Rules\ExistsInCourses;
use App\Exceptions\RequestValidationFailed;


class RegisterAccountRequest extends FormRequest
{
    public function rules()
    {
        return [
            'apc_id' => 'required|string|unique:users',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'course_id' => ['required', 'string', new ExistsInCourses],
            'isEmployee' => 'boolean'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $message = "Registration Failed";
        $method = "POST";
        $errorCode = 422;
        RequestValidationFailed::errorResponse($validator, $message, $method, $errorCode);
    }
}