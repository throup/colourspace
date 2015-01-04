<?php
/**
 * This file contains test cases for the RgbColour class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

use PHPUnit_Framework_TestCase;

/**
 * Class RgbColourTest
 */
class RgbColourTest extends PHPUnit_Framework_TestCase {
    const RED_X = 0.412423758;
    const RED_Y = 0.212656;
    const RED_Z = 0.019332364;
    const DELTA = 0.0003;

    /**
     * @test
     */
    public function constructionWithValues_setsRGBValues() {
        $red   = 0.2;
        $green = 0.4;
        $blue  = 0.8;

        $colour = $this->generateRgbColour($red, $green, $blue);
        $colourspace = new Space\sRGB();

        $expected = [
            'R' => $red,
            'G' => $green,
            'B' => $blue,
        ];

        $this->assertEquals($expected, $colourspace->identify($colour));
    }

    /**
     * @test
     */
    public function equal() {
        $first  = $this->generateRgbColour(1, 0, 0);
        $second = $this->generateRgbColour(1, 0, 0);

        $this->assertTrue($first->equals($second));
        $this->assertTrue($second->equals($first));
    }

    /**
     * @test
     */
    public function notEqual() {
        $first  = $this->generateRgbColour(1, 0, 0);
        $second = $this->generateRgbColour(0, 0, 1);

        $this->assertFalse($first->equals($second));
        $this->assertFalse($second->equals($first));
    }

    /**
     * @test
     */
    public function getX_returnsExpectedValues() {
        $R = 1.0;    $G = 0.0;    $B = 0.0;
        $X = self::RED_X;

        $colour = $this->generateRgbColour($R, $G, $B);

        $this->assertEquals($X, $colour->getX(), '', self::DELTA);
    }

    /**
     * @test
     */
    public function getY_returnsExpectedValues() {
        $R = 1.0;    $G = 0.0;    $B = 0.0;
        $Y = self::RED_Y;

        $colour = $this->generateRgbColour($R, $G, $B);

        $this->assertEquals($Y, $colour->getY(), '', self::DELTA);
    }

    /**
     * @test
     */
    public function getZ_returnsExpectedValues() {
        $R = 1.0;    $G = 0.0;    $B = 0.0;
        $Z = self::RED_Z;

        $colour = $this->generateRgbColour($R, $G, $B);

        $this->assertEquals($Z, $colour->getZ(), '', self::DELTA);
    }

    /**
     * Generate a testable colour object for the provided RGB representation.
     *
     * @param float $red   The red component of this colour's RGB
     *                     representation; in the range [0.0–1.0].
     * @param float $green The green component of this colour's RGB
     *                     representation; in the range [0.0–1.0].
     * @param float $blue  The blue component of this colour's RGB
     *                     representation; in the range [0.0–1.0].
     *
     * @return Colour
     */
    protected function generateRgbColour($red   = 0.0,
                                         $green = 0.0,
                                         $blue  = 0.0) {
        $colourspace = new Space\sRGB();
        return $colourspace->generate($red, $green, $blue);
    }
}
