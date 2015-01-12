<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BowlingGame3Spec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BowlingGame3');
    }

    function it_scores_zero()
    {
        $this->roll(0);

        $this->score()->shouldBe(0);
    }
}
