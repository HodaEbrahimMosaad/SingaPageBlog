<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class Article extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
          "id" => $this->id,
          "title" => $this->title,
          "body" => $this->body,
        ];
    }
    public function with($request)
    {
        $user =User::first();
        return [
            "auther" => $user->name
        ];
    }
}
