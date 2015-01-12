<?php

class BowlingGame3
{
    protected $score;

    public function roll($argument1)
    {
        $this->score += $argument1;
    }

    public function score()
    {
        return $this->score;
    }
}
