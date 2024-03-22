<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'title'     => $this->title,
            'title_lang'=> [
                'ar'    => $this->getTranslation('title', 'ar'),
                'en'    => $this->getTranslation('title', 'en'),
            ],
            'content'   => $this->content,
            'content_lang' => [
                'ar'    => $this->getTranslation('content', 'ar'),
                'en'    => $this->getTranslation('content', 'en'),
            ],
            'image'     => $this->image,
            'user'      => [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'email' => $this->user->email,
            ],
            'created_at' => $this->created_at->diffForHumans(),
            'comments'   => CommentResource::collection($this->comments()->latest()->get()),
            'links'     => $this->links,
            'is_owner'  => $this->is_owner,
        ];
    }
}
