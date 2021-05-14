<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthLoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function __construct(User $user)
    {
        $this->user=$user;
    }

    public function toArray(User $user) {
        return [
            'access_token'=> $this->user->createToken($this->user->email)->plainTextToken 
            'user'=> new UserResource($this->user) 
        ]
    }
}
