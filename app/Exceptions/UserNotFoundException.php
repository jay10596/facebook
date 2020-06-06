<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'errors' => [
                'code' => 404,
                'title' => 'User not found',
                'detail' => 'Unable to locate user with given information'
            ]
        ], 404);
    }
}
