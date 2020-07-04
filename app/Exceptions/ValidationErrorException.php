<?php

namespace App\Exceptions;

use Exception;

class ValidationErrorException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'errors' => [
                'code' => 422,
                'title' => 'Validated field not found',
                'detail' => 'Unable to fetch required fields with given information',
                'meta' => json_decode($this->getMessage()) //Convert back the string into the array
            ]
        ], 422);
    }
}
