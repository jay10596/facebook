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
                'title' => 'User not found',
                'detail' => 'Unable to locate user with given information',
                'meta' => json_decode($this->getMessage()) //Convert back the string into the array
            ]
        ], 422);
    }
}
