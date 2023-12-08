<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Utils\ValidatorReturnDataCleanup;

class RequestValidationFailed extends Exception
{
    /**
     * Throw an exception with validation errors.
     *
     * @param object $validator
     * @param string $message
     * @param string $method
     * @param int $errorCode
     *
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    public static function errorResponse($validator, $message, $method, $errorCode)
    {
        $errors = $validator->errors()->get('*');
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
