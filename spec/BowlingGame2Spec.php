<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BowlingGame2Spec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('BowlingGame2');
    }

    function it_scores_a_gutter_game_as_zero() {
        $this->rollMany(20, 0);

        $this->score()->shouldBe(0);
    }

    function it_scores_twenty_if_single_pins_are_hit_each_go() {
        $this->rollMany(20, 1);

        $this->score()->shouldBe(20);
    }

    function it_scores_a_spare()
    {
        $this->roll(4);
        $this->roll(6);
        $this->roll(4);
        $this->roll(2);

        $this->score()->shouldBe(20);
    }

    function it_scores_a_strike()
    {
        $this->roll(10);
        $this->roll(10);
        $this->roll(4);
        $this->roll(2);

        $this->score()->shouldBe(46);
    }

    function it_scores_a_turkey()
    {
        $this->rollMany(3, 10);

        $this->score()->shouldBe(60);
    }

    function it_scores_a_perfect_game()
    {
        $this->rollMany(12, 10);

        $this->score()->shouldBe(300);
    }

    function it_scores_1_away_from_a_perfect_game()
    {
        $this->rollMany(11, 10);

        $this->score()->shouldBe(290);
    }

    function it_scores_2_away_from_a_perfect_game()
    {
        $this->rollMany(10, 10);

        $this->score()->shouldBe(270);
    }

    function it_scores_all_gutter_balls_apart_from_3_strikes_at_the_end()
    {
        $this->rollMany(18, 0);
        $this->rollMany(3, 10);

        $this->score()->shouldBe(30);
    }

    function it_scores_all_5_spares()
    {
        $this->rollMany(21, 5);

        $this->score()->shouldBe(150);
    }

    function it_scores_10_strikes_and_a_spare()
    {
        $this->rollMany(10, 10);
        $this->rollMany(2, 5);

        $this->score()->shouldBe(285);
    }

    function it_scores_all_9_spares()
    {
        for ($i = 0; $i < 10; $i++) {
            $this->roll(9);
            $this->roll(1);
        }
        $this->roll(9);

        $this->score()->shouldBe(190);
    }

    private function rollMany($rolls, $pins)
    {
        for ($i = 0; $i < $rolls; $i++) {
            $this->roll($pins);
        }
    }
}
