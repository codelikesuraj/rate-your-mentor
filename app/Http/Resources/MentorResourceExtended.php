<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MentorResourceExtended extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'total_votes' => $this->votes->count(),
            'total_votes_by_category' => $this->votes->groupBy("category_id")
                ->map(function ($votes) {
                    return [
                        'category' => $votes->first()->category,
                        'total_votes' => $votes->count()
                    ];})
                ->values(),
        ];
    }
}
