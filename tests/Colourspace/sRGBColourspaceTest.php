<?php
/**
 * This file contains test cases for the sRGBColourspace class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

use PHPUnit_Framework_TestCase;

/**
 * Tests for the representation of the sRGB colourspace.
 */
class sRGBColourspaceTest extends PHPUnit_Framework_TestCase {
    /**
     * @before
     */
    public function setUp() {
        $this->colourspace = new sRGBColourspace();
    }

    /**
     * @test
     */
    public function whitePoint_returnsImplementationOfColour() {
        $this->assertIsColour($this->colourspace->whitePoint());
    }

    /**
     * @test
     */
    public function whitePoint_matchesD65() {
        $whitePoint = $this->colourspace->whitePoint();
        $expected = [
            'X' => 0.95047,
            'Y' => 1.00000,
            'Z' => 1.08883,
        ];
        $result = [
            'X' => $whitePoint->getX(),
            'Y' => $whitePoint->getY(),
            'Z' => $whitePoint->getZ(),
        ];
        $this->assertEquals($expected, $result, '', 0.00065);
    }

    /**
     * @test
     */
    public function primaries_returnsIterableCollectionOfColours() {
        foreach ($this->colourspace->primaries() as $colour) {
            $this->assertIsColour($colour);
        }
    }

    /**
     * @test
     */
    public function primaries_returnsArrayContainingThreeItems() {
        $this->assertCount(3, $this->colourspace->primaries());
    }

    /**
     * @test
     */
    public function primaries_keysAre_RGB_() {
        $expected = [
            'R',
            'G',
            'B',
        ];
        $keys = array_keys($this->colourspace->primaries());
        $this->assertEquals($expected, $keys);
    }

    /**
     * @test
     * @dataProvider primaries_data
     */
    public function primaries_matchesSpecification($primary, $X, $Y, $Z) {
        $primaries = $this->colourspace->primaries();
        $colour = $primaries[$primary];

        $expected = [
            'X' => $X,
            'Y' => $Y,
            'Z' => $Z,
        ];
        $result = [
            'X' => $colour->getX(),
            'Y' => $colour->getY(),
            'Z' => $colour->getZ(),
        ];
        $this->assertEquals($expected, $result, '', 0.0002);
    }

    public function primaries_data() {
        return [
            ['R', 0.4124564, 0.2126729, 0.0193339],
            ['G', 0.3575761, 0.7151522, 0.1191920],
            ['B', 0.1804375, 0.0721750, 0.9503041],
        ];
    }

    /**
     * @test
     * @dataProvider XYZtoRGB_data
     */
    public function identify_returnsCorrectRGBValues($X, $Y, $Z, $R, $G, $B) {
        $colour = new XyzColour($X, $Y, $Z);

        $expected = [
            'R' => $R,
            'G' => $G,
            'B' => $B,
        ];
        $result = $this->colourspace->identify($colour);
        $this->assertEquals($expected, $result, '', 0.0005);
    }

    /**
     * @test
     * @dataProvider XYZtoRGB_data
     */
    public function generate_returnsColourWithCorrectXYZValues($X, $Y, $Z, $R, $G, $B) {
        $colour = $this->colourspace->generate($R, $G, $B);

        $expected = [
            'X' => $X,
            'Y' => $Y,
            'Z' => $Z,
        ];
        $result = [
            'X' => $colour->getX(),
            'Y' => $colour->getY(),
            'Z' => $colour->getZ(),
        ];
        $this->assertEquals($expected, $result, '', 0.00065);
    }

    public function XYZtoRGB_data() {
        return [
            [0.4124564, 0.2126729, 0.0193339, 1.0, 0.0, 0.0],
            [0.3575761, 0.7151522, 0.1191920, 0.0, 1.0, 0.0],
            [0.1804375, 0.0721750, 0.9503041, 0.0, 0.0, 1.0],
        ];
    }

    /**
     * Asserts that the variable is an implementation of Colour.
     *
     * @param Colour $colour
     */
    protected function assertIsColour(Colour $colour) {
        $colour;
    }

    /**
     * @var sRGBColourspace
     */
    private $colourspace;
}
