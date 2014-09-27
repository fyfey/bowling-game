<?php

class BowlingGame2
{
    const FRAMES_PER_GAME = 10;

    protected $bonusStack;
    protected $rolls = [];

    protected $frame      = 1;
    protected $roll       = 0;
    protected $totalRolls = 0;

    protected $score = 0;

    public function __construct()
    {
        $this->bonusStack = [];
    }

    public function roll($pins)
    {
        $this->rolls[$this->frame][$this->roll] = $pins;

        $this->updateScore();
        $this->addBonuses();
        $this->calcSpareBonus();
        $this->calcStrikeBonus();
        $this->nextRoll();
    }

    public function score()
    {
        return $this->score;
    }

    protected function nextRoll()
    {
        if ($this->roll == 1) {
            $this->roll = 0;
            $this->frame++;
        } else {
            $this->roll++;
        }
        $this->totalRolls++;
    }

    protected function updateScore()
    {
        $this->score += $this->rolls[$this->frame][$this->roll];
    }

    protected function addBonuses()
    {
        if (isset($this->bonusStack[$this->totalRolls])) {
            foreach ($this->bonusStack[$this->totalRolls] as $func) {
                $func();
            }
        }
    }

    protected function getFrameScores($frame)
    {
        return $this->rolls[$frame];
    }

    protected function frameScore($frame)
    {
        $score = $this->rolls[$frame][0];
        if (isset($this->rolls[$frame][1])) {
            $score += $this->rolls[$frame][1];
        }
        if (isset($this->rolls[$frame][2])) {
            $score += $this->rolls[$frame][2];
        }

        return $score;
    }

    protected function addBonus($ahead, $func) {
        if (!isset($this->bonusStack[$this->totalRolls+$ahead])) {
            $this->bonusStack[$this->totalRolls+$ahead] = [];
        }
        $this->bonusStack[$this->totalRolls+$ahead][] = $func;
    }

    protected function calcSpareBonus()
    {
        if ($this->roll === 1 && $this->frameScore($this->frame) === 10 && $this->frame != 10) {
            $this->addBonus(1, function() {
                $this->score += $this->getFrameScores($this->frame)[0];
            });
        }
    }

    protected function calcStrikeBonus()
    {
        if ($this->roll === 0 && $this->frameScore($this->frame) === 10) {
            if ($this->frame < self::FRAMES_PER_GAME) {
                $this->addBonus(1, function() {
                    $this->score += $this->rolls[$this->frame][$this->roll];
                });
            }
            if ($this->frame < self::FRAMES_PER_GAME) {
                $this->addBonus(2, function() {
                    $this->score += $this->rolls[$this->frame][$this->roll];
                });
            }
            $this->roll++;
        }
    }
}
