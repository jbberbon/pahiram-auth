<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Utils\ValidatorReturnDataCleanup;

class RequestValidationFailedMsg extends Exception
{

    public static function errorResponse($validator, $message, $errorCode)
    {
        $errors = $validator->errors()->get('*');
        $method = request()->method();
        throw new HttpResponseException(
            response([
                'status' => false,
                'message' => $message,
                'errors' => ValidatorReturnDataCleanup::cleanup($errors),
                'method' => $method,
            ], $errorCode)
        );
    }
}
