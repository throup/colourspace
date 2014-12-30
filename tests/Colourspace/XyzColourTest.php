<?php
/**
 * This file contains test cases for the XyzColour class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

use PHPUnit_Framework_TestCase;

/**
 * Class XyzColourTest
 */
class XyzColourTest extends PHPUnit_Framework_TestCase {
    const RED_X = 0.412423758;
    const RED_Y = 0.212656;
    const RED_Z = 0.019332364;
    const DELTA = 0.00005;

    /**
     * @test
     */
    public function constructionWithValues_setsXYZValues() {
        $X = 0.2;
        $Y = 0.4;
        $Z = 0.8;

        $colour = $this->generateXyzColour($X, $Y, $Z);

        $this->assertEquals($X, $colour->getX());
        $this->assertEquals($Y, $colour->getY());
        $this->assertEquals($Z, $colour->getZ());
    }

    /**
     * @test
     */
    public function equal() {
        $first  = $this->generateXyzColour(1, 0, 0);
        $second = $this->generateXyzColour(1, 0, 0);

        $this->assertTrue($first->equals($second));
        $this->assertTrue($second->equals($first));
    }

    /**
     * @test
     */
    public function notEqual() {
        $first  = $this->generateXyzColour(1, 0, 0);
        $second = $this->generateXyzColour(0, 0, 1);

        $this->assertFalse($first->equals($second));
        $this->assertFalse($second->equals($first));
    }

    /**
     * @test
     */
    public function getRed_returnsExpectedValues() {
        $X = self::RED_X; $Y = self::RED_Y; $Z = self::RED_Z;
        $R = 1;

        $colour = $this->generateXyzColour($X, $Y, $Z);

        $this->assertEquals($R, $colour->getRed(), '', self::DELTA);
    }

    /**
     * @test
     */
    public function getGreen_returnsExpectedValues() {
        $X = self::RED_X; $Y = self::RED_Y; $Z = self::RED_Z;
        $G = 0;

        $colour = $this->generateXyzColour($X, $Y, $Z);

        $this->assertEquals($G, $colour->getGreen(), '', self::DELTA);
    }

    /**
     * @test
     */
    public function getBlue_returnsExpectedValues() {
        $X = self::RED_X; $Y = self::RED_Y; $Z = self::RED_Z;
        $B = 0;

        $colour = $this->generateXyzColour($X, $Y, $Z);

        $this->assertEquals($B, $colour->getBlue(), '', self::DELTA);
    }

    /**
     * Generate a testable colour object for the provided XYZ representation.
     *
     * @param float $X The X component of this colour's XYZ representation; in
     *                 the range [0.0–1.0].
     * @param float $Y The Y component of this colour's XYZ representation; in
     *                 the range [0.0–1.0].
     * @param float $Z The Z component of this colour's XYZ representation; in
     *                 the range [0.0–1.0].
     *
     * @return XyzColour
     */
    protected function generateXyzColour($X = 0.0,
                                         $Y = 0.0,
                                         $Z = 0.0) {
        return new XyzColour($X, $Y, $Z);
    }
}
