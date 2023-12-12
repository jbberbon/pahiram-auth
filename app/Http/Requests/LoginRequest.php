<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

use App\Http\Rules\ExistsInUsers;
use App\Exceptions\RequestExtraPayloadMsg;
use App\Exceptions\RequestValidationFailedMsg;

class LoginRequest extends FormRequest
{
    private $errorCode = 422;
    public function rules()
    {
        return [
            'email' => ['required', 'string', new ExistsInUsers],
            'password' => 'required|string|min:8',
            'remember_me' => 'boolean',
        ];
    }
    protected function passedValidation()
    {
        $request = $this->input();
        $rules = $this->rules();
        $errorCode = $this->errorCode;
        RequestExtraPayloadMsg::errorResponse($request, $rules, $errorCode);
    }


    public function failedValidation(Validator $validator)
    {
        $message = "Login Failed";
        $errorCode = $this->errorCode;;
        RequestValidationFailedMsg::errorResponse($validator, $message, $errorCode);
    }
}