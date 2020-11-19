<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RankResource extends JsonResource
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
            'team_id' => $this->team_id,
            'game_played' => $this->game_played,
            'win' => $this->win,
            'loss' => $this->loss,
            'draw' => $this->draw,
            'goal_diff' => $this->goal_diff,
            'team_name' => $this->team->name,
            'team_logo' => $this->team->logo,
        ];
    }
}
