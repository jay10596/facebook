<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Resources\Friend as FriendResource;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Exceptions\RequestNotFoundException;
use App\Exceptions\ValidationErrorException;
use Illuminate\Validation\ValidationException;

use App\User;
use App\Friend;
use Auth;


class FriendController extends Controller
{
    //In postman, we have to pass friend_id as we are not using RMB here.
    public function sendRequest(Request $request)
    {
        $data = request()->validate([
            'friend_id' => 'required'
        ]);

        /*We have to find user because here we are not using Route Model Binding.
        For RMB, the route would be like:
		    Route::post('/replies/{reply}/like', 'LikeController@likeIt');
        And the function would be like:
            public function likeIt(Reply $reply)
			    {
			        $reply->likes()->create([
			            'user_id' => auth()-> id(),
			        ]);
			    }
        */
        try {
            $user = User::findOrFail($data['friend_id']);
        } catch (ModelNotFoundException $e){
            throw new UserNotFoundException();
        }

        //Attach is used for many to many (belongsToMany) relationship.
        //Attach will cause repeat the same values in database. In the migration unique has been added which is why attach will try to add the same user_id and friend_id and it will give integrity constrain error.
        $user->friends()->syncWithoutDetaching(Auth::user());

        /*If you want to use hasMany instead of belongsToMany you have to use create
            $user->friends()->create([
                'friend_id' => $data['friend_id'], 'user_id' => 1
            ]);
        */

        $friendRequest = Friend::where('user_id', auth()->user()->id)
            ->where('friend_id', $data['friend_id'])
            ->first();

        return new FriendResource($friendRequest);
    }

    public function confirmRequest(Request $request)
    {
        $data = request()->validate([
            'user_id' => 'required',
        ]);

        try {
            $friendRequest = Friend::where('user_id', $data['user_id'])
                ->where('friend_id', auth()->user()->id)
                ->firstOrFail();
        } catch (ModelNotFoundException $e){
            throw new RequestNotFoundException();
        }

        $friendRequest->update(array_merge($data, ['confirmed_at' => now(), 'status' => '1']));

        return new FriendResource($friendRequest);
    }

    public function deleteRequest(Request $request)
    {
        $data = request()->validate([
            'user_id' => 'required',
        ]);

        try {
            $friendRequest = Friend::where('user_id', $data['user_id'])
                ->where('friend_id', auth()->user()->id)
                ->firstOrFail()
                ->delete();
        } catch (ModelNotFoundException $e){
            throw new RequestNotFoundException();
        }

        return response()->json([], 204);
    }
}
