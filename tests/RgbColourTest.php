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

        $colour = new RgbColour($red, $green, $blue);

        $this->assertEquals($red,   $colour->getRed());
        $this->assertEquals($green, $colour->getGreen());
        $this->assertEquals($blue,  $colour->getBlue());
    }

    /**
     * @test
     */
    public function equal() {
        $first  = new RgbColour(1, 0, 0);
        $second = new RgbColour(1, 0, 0);

        $this->assertTrue($first->equals($second));
        $this->assertTrue($second->equals($first));
    }

    /**
     * @test
     */
    public function notEqual() {
        $first  = new RgbColour(1, 0, 0);
        $second = new RgbColour(0, 0, 1);

        $this->assertFalse($first->equals($second));
        $this->assertFalse($second->equals($first));
    }
}
