<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use App\Exceptions\RequestValidationFailed;
use App\Http\Rules\ExistsInUsers;



class LoginRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => ['required', 'string', new ExistsInUsers],
            'password' => 'required|string|min:8',
            'remember_me' => 'boolean',
            '*' => Rule::notIn(array_keys($this->rules())),
        ];
    }

    public function failedValidation(Validator $validator)
    {
        $message = "Login Failed";
        $method = "POST";
        $errorCode = 401;
        RequestValidationFailed::errorResponse($validator, $message, $method, $errorCode);
    }
}