<?php
namespace App\Utils;
class GetExtraRequestFields {
    public static function getExtraFields($validator)
    {
        // This contains all the Request Payload
        $requestData = $validator->attributes();

        // Check if there are extra fields not defined in the rules
        $requestFields = array_keys($requestData);
        $allowedFields = array_keys($validator->getRules());

        return array_diff($requestFields, $allowedFields);
    }
}