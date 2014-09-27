<?php

class BowlingGame
{
    const FRAMES_PER_GAME = 10;

    private $rolls = [];
    private $scorecard = [];

    public function roll($pins)
    {
        if ($pins < 0 || $pins > 10) {
            throw new InvalidArgumentException('Invalid roll!');
        }
        $this->rolls[] = $pins;
    }

    /**
     * Calculate the score for the current game
     *
     * @return void
     */
    public function score()
    {
        $score = 0;
        $roll  = 0;

        for ($frame = 1; $frame <= self::FRAMES_PER_GAME; $frame++) {
            if ($this->isSpare($roll)) {
                $score += (10 + $this->firstBowlAfterSpare($roll));
                $roll += 2;
            } else if ($this->isStrike($roll)) {
                $score += (10 + $this->next2Rolls($roll));
                $roll ++;
            } else {
                if ($this->thisRoll($roll) + $this->nextRoll($roll) > 10) {
                    throw new \InvalidArgumentException('There aren\'t enough pins!');
                }
                $score += $this->rolls[$roll++];
                $score += $this->rolls[$roll++];
            }
        }

        return $score;
    }

    public function scorecard()
    {
        $score = 0;
        $roll  = 0;

        for ($frame = 1; $frame <= self::FRAMES_PER_GAME; $frame++) {
            if ($this->isSpare($roll)) {
                $score += (10 + $this->firstBowlAfterSpare($roll));
                $scorecard[] = [$this->thisRoll($roll), '/', $score];
                $roll += 2;
            } else if ($this->isStrike($roll)) {
                $score += (10 + $this->next2Rolls($roll));
                $scorecard[] = ['X', '', $score];
                $roll ++;
            } else {
                $score += $this->thisRoll($roll);
                $score += $this->nextRoll($roll);
                $scorecard[] = [$this->thisRoll($roll), $this->nextRoll($roll), $score];
                $roll += 2;
            }
        }

        return $scorecard;
    }

    protected function nextRoll($currentRoll)
    {
        return $this->rolls[$currentRoll+1];
    }

    protected function thisRoll($currentRoll)
    {
        return $this->rolls[$currentRoll];
    }

    protected function firstBowlAfterSpare($currentRoll)
    {
        return $this->rolls[$currentRoll+2];
    }

    protected function next2Rolls($currentRoll)
    {
        return $this->rolls[$currentRoll+1] + $this->rolls[$currentRoll+2];
    }

    protected function isSpare($currentRoll)
    {
        return $this->thisRoll($currentRoll) !== 10 && $this->rolls[$currentRoll] + $this->rolls[$currentRoll+1] === 10;
    }

    protected function isStrike($currentRoll)
    {
        return $this->rolls[$currentRoll] === 10;
    }
}
