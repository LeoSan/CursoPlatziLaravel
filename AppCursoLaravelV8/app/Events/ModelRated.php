<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use Illuminate\Database\Eloquent\Model;



class ModelRated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private Model $rating;
    private Model $course;
    private float $score;    

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Model $rating, Model $course,  float $score)
    {
        //
        $this->course = $course;
        $this->rating = $rating;
        $this->score = $score;
    }

    public function getRating(): Model
    {
        return $this->rating;
    }

    public function getCourse(): Model
    {
        return $this->course;
    }

    public function getScore(): float
    {
        return $this->score;
    }

}
