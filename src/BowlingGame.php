<?php

class BowlingGame
{
    const FRAMES_PER_GAME = 10;

    private $rolls = [];

    public function roll($pins)
    {
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

        $frames = self::FRAMES_PER_GAME;

        for ($frame = 1; $frame <= $frames; $frame++) {
            $r           = $this->rolls;
            if (count($r) === $roll) {
                break;
            }
            $thisRoll    = $r[$roll];
            $lastRoll    = (isset($r[$roll-1])) ? $r[$roll-1] : 0;
            $twoRollsAgo = (isset($r[$roll-2])) ? $r[$roll-2] : 0;

            // If last frame was a spare
            if ($lastRoll + $twoRollsAgo === 10 && $lastRoll > 0 && $twoRollsAgo > 0) {
                $score += $thisRoll;
            }

            if ($this->isStrike($lastRoll)) {
                $score += 10;
            }
            if ($this->isStrike($twoRollsAgo)) {
                $score += 10;
            }

            $score += $thisRoll;
            if ($this->isStrike($thisRoll)) {
                if ($roll+1 === self::FRAMES_PER_GAME) {
                    $frames++;
                }

                $roll++;
                continue;
            }

            $roll++;
            if (count($r) === $roll) {
                break;
            }

            $score += $r[$roll];
            $roll++;
        }

        return $score;
    }

    protected function isStrike($pins)
    {
        return $pins === 10;
    }
}
