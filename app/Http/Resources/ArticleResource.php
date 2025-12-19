<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'author' => $this->author->name,
            'status' => $this->status,
            'categories' => $this->categories->pluck('name'),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
