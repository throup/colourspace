<?php
/**
 * This file contains test cases for the xyYColour class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

use PHPUnit_Framework_TestCase;

/**
 * Class xyYColourTest
 */
class xyYColourTest extends PHPUnit_Framework_TestCase {
    const RED_X = 0.412423758;
    const RED_Y = 0.212656;
    const RED_Z = 0.019332364;
    const DELTA = 0.0003;

    /**
     * @test
     */
    public function constructionWithValues_setsxyYValues() {
        $x = 0.2;
        $y = 0.4;
        $Y = 0.8;

        $colour = $this->generate_xyYColour($x, $y, $Y);

        $this->assertEquals($x, $colour->get_x());
        $this->assertEquals($y, $colour->get_y());
        $this->assertEquals($Y, $colour->getY());
    }

    /**
     * @test
     */
    public function equal() {
        $first  = $this->generate_xyYColour(0.2, 0.4, 0.8);
        $second = $this->generate_xyYColour(0.2, 0.4, 0.8);

        $this->assertTrue($first->equals($second));
        $this->assertTrue($second->equals($first));
    }

    /**
     * @test
     */
    public function notEqual() {
        $first  = $this->generate_xyYColour(0.2, 0.4, 0.8);
        $second = $this->generate_xyYColour(0.1, 0.3, 1);

        $this->assertFalse($first->equals($second));
        $this->assertFalse($second->equals($first));
    }

    /**
     * Generate a testable colour object for the provided xyY representation.
     *
     * @param float $x The x component of this colour's xyY representation; in
     *                 the range [0.0–1.0].
     * @param float $y The (little) y component of this colour's xyY
     *                 representation; in the range [0.0–1.0].
     * @param float $Y The (big) Y component of this colour's xyY
     *                 representation; in the range [0.0–1.0].
     *
     * @return xyYColour
     */
    protected function generate_xyYColour($x = 0.0,
                                          $y = 0.0,
                                          $Y = 0.0) {
        return new xyYColour($x, $y, $Y);
    }
}

