<?php

namespace Bhittani\StarRating;

use WP_UnitTestCase;

class MathTest extends WP_UnitTestCase
{
    /** @test*/
    function it_normalizes_the_ratings_to_a_base()
    {
        $this->assertSame(3, toNormalizedRatings(3));
        $this->assertSame(1.5, toNormalizedRatings(3, 10));
        $this->assertSame(2.1, toNormalizedRatings(3, 10, 7));
        $this->assertSame(2.5, toNormalizedRatings(5, 10));
    }

    /** @test*/
    function it_calculates_the_score()
    {
        $this->assertSame(0, calculateScore(0, 0));
        $this->assertSame(0, calculateScore(0, 0, 10));

        $this->assertSame(5.0, calculateScore(20, 4));
        $this->assertSame(10.0, calculateScore(20, 4, 10));

        $this->assertSame(4.0, calculateScore(20, 5));
        $this->assertSame(8.0, calculateScore(20, 5, 10));

        $this->assertSame(3.7, calculateScore(15, 4));
        $this->assertSame(7.5, calculateScore(15, 4, 10));
    }

    /** @test*/
    function it_calculates_the_percentage()
    {
        $this->assertSame(0, calculatePercentage(0, 0));
        $this->assertSame(100.0, calculatePercentage(20, 4));
        $this->assertSame(80.0, calculatePercentage(20, 5));
        $this->assertSame(75.0, calculatePercentage(15, 4));
    }

    /** @test*/
    function it_calculates_ratings_for_dynamic_sizes()
    {
        foreach([
            [5, 4.0, 80.0, [3, 4, 5]],
            [10, 8.0, 80.0, [6, 8, 10]],
        ] as $t) {
            $r = toNormalizedRatings(array_sum($t[3]), $t[0]);
            $this->assertSame($t[1], calculateScore($r, count($t[3]), $t[0]));
            $this->assertSame($t[2], calculatePercentage($r, count($t[3])));
        }

        foreach([
            [
                [5, 4.0, 80.0],
                [10, 8.0, 80.0],
                [
                    [3, 5],
                    [4, 5],
                    [5, 5],
                    [6, 10],
                    [8, 10],
                    [10, 10],
                ],
            ],
        ] as $t) {
            $ratings = 0;
            foreach ($t[2] as $r) {
                $ratings += toNormalizedRatings($r[0], $r[1]);
            }
            $this->assertSame(24, $ratings);
            $this->assertSame($t[0][1], calculateScore($ratings, count($t[2]), $t[0][0]));
            $this->assertSame($t[0][2], calculatePercentage($ratings, count($t[2])));
            $this->assertSame($t[1][1], calculateScore($ratings, count($t[2]), $t[1][0]));
            $this->assertSame($t[1][2], calculatePercentage($ratings, count($t[2])));
        }
    }
}
