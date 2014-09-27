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
        $this->rollMany(20, 0);

        $this->score()->shouldBe(0);
    }

    function it_scores_twenty_if_all_single_pins()
    {
        $this->rollMany(20, 1);

        $this->score()->shouldBe(20);
    }

    function it_scores_a_spare()
    {
        $this->roll(4);
        $this->roll(6);
        $this->roll(5);
        $this->rollMany(17, 0);

        $this->score()->shouldBe(20);
    }

    function it_scores_a_strike()
    {
        $this->roll(10);
        $this->roll(4);
        $this->roll(3);
        $this->rollMany(16, 0);

        $this->score()->shouldBe(24);
    }

    function it_should_score_a_perfect_game()
    {
        $this->rollMany(12, 10);
        $this->score()->shouldBe(300);
    }

    function it_should_not_allow_an_invalid_roll()
    {
        $this->shouldThrow('\InvalidArgumentException')->duringRoll(11);
    }

    function it_should_stop_a_normal_game_at_10_frames()
    {
        $this->rollMany(20,  1);
        $this->score()->shouldBe(20);
        $this->roll(10);
        $this->score()->shouldBe(20);
    }

    function it_should_not_allow_more_than_ten_per_frame()
    {
        $this->roll(4);
        $this->roll(7);
        $this->shouldThrow('\InvalidArgumentException')->duringScore();
    }

    function it_should_print_out_a_score_card()
    {
        $this->roll(3);
        $this->roll(7);
        $this->roll(3);
        $this->roll(2);
        $this->roll(10);
        $this->rollMany(15, 0);

        $this->scorecard()->shouldBe([
            [3, '/', 13],
            [3, 2, 18],
            ['X', '', 28],
            [0, 0, 28],
            [0, 0, 28],
            [0, 0, 28],
            [0, 0, 28],
            [0, 0, 28],
            [0, 0, 28],
            [0, 0, 28],
        ]);
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

    private function rollMany($count, $pins)
    {
        for ($i = 0; $i < $count; $i++) {
            $this->roll($pins);
        }
    }
}
