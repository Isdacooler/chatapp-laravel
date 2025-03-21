<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'user'       => new UserResource($this->whenLoaded('user')),
            'content'    => $this->content,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
