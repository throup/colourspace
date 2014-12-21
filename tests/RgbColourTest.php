<?php

namespace Colourspace;

/**
 * Class RgbColourTest
 */
class RgbColourTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function constructionWithValues_setsRGBValues() {
        $red   = 0.2;
        $green = 0.4;
        $blue  = 0.8;

        $colour = $this->generateRgbColour($red, $green, $blue);

        $this->assertEquals($red,   $colour->getRed());
        $this->assertEquals($green, $colour->getGreen());
        $this->assertEquals($blue,  $colour->getBlue());
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
     * Generate a testable colour object for the provided RGB representation.
     *
     * @param float $red   The red component of this colour's RGB
     *                     representation; in the range [0.0–1.0].
     * @param float $green The green component of this colour's RGB
     *                     representation; in the range [0.0–1.0].
     * @param float $blue  The blue component of this colour's RGB
     *                     representation; in the range [0.0–1.0].
     *
     * @return RgbColour
     */
    protected function generateRgbColour($red   = 0.0,
                                         $green = 0.0,
                                         $blue  = 0.0) {
        return new RgbColour($red, $green, $blue);
    }
}
