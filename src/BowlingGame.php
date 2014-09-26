<?php

class BowlingGame
{
    private $score;

    public function __construct()
    {
        $this->score = 0;
    }

    public function roll($pins)
    {
        $this->score += $pins;
    }

    public function score()
    {
        return $this->score;
    }
}
