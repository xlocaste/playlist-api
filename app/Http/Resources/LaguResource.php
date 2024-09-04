<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class LaguResource extends JsonResource
{
    //define properti
    public $status;
    public $message;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            // 'success'   => $this->status,
            // 'message'   => $this->message,
                'id' => $this->id,
                'mp3' => $this->mp3,
                'title' => $this->title,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
        ];
    }
}
