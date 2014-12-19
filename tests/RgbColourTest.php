<?php

namespace colourspace;

/**
 * Class RgbColourTest
 *
 * @package throup\colourspace
 */
class RgbColourTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function init() {
        new RgbColour();
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
