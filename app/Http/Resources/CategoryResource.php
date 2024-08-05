<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'total_votes'=> $this->votes->count(),
            'total_votes_by_mentor'=> $this->votes->groupBy("mentor_id")
                ->map(function ($votes) {
                    return [
                        'mentor' => $votes->first()->mentor,
                        'total_votes' => $votes->count()
                    ];})
                ->values(),
        ];
    }
}
