<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BowlingGameSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BowlingGame');
    }

    function it_scores_a_gutter_game_as_zero()
    {
        $this->rollTimes(20, 0);

        $this->score()->shouldBe(0);
    }

    function it_scores_twenty_if_all_single_pins()
    {
        $this->rollTimes(20, 1);

        $this->score()->shouldBe(20);
    }

    function it_scores_a_perfect_game_as_three_hundred()
    {
        $this->rollTimes(12, 10);

        $this->score()->shouldBe(300);
    }

    function it_scores_a_single_turkey_as_sixty()
    {
        $this->rollTimes(3, 10);
        $this->rollTimes(14, 0);

        $this->score()->shouldBe(60);
    }

    function it_scores_a_spare_plus_six_as_twenty()
    {
        $this->roll(6);
        $this->roll(4);
        $this->roll(4);
        $this->roll(2);
        $this->rollTimes(16, 0);

        $this->score()->shouldBe(20);
    }

    private function rollTimes($count, $pins)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->roll($pins);
        }
    }
}
