<?php

namespace App\Exceptions;

use Exception;

class RequestNotFoundException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'errors' => [
                'code' => 404,
                'title' => 'Friend Request not found',
                'detail' => 'Unable to locate friend request with given information'
            ]
        ], 404);
    }
}
