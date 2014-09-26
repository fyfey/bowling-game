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

    private function rollTimes($count, $pins)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->roll($pins);
        }
    }
}
