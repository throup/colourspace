<?php
/**
 * This file contains test cases for the XYZColourspace class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

use Colourspace\Colourspace\Colour\XYZ;
use PHPUnit_Framework_TestCase;

/**
 * Tests for the representation of the XYZ colourspace.
 */
class XYZColourspaceTest extends PHPUnit_Framework_TestCase {
    /**
     * @before
     */
    public function setUp() {
        $this->colourspace = new XYZColourspace();
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
    public function whitePoint_matchesE() {
        $whitePoint = $this->colourspace->whitePoint();
        $expected = [
            'X' => 1,
            'Y' => 1,
            'Z' => 1,
        ];
        $result = [
            'X' => $whitePoint->getX(),
            'Y' => $whitePoint->getY(),
            'Z' => $whitePoint->getZ(),
        ];
        $this->assertEquals($expected, $result);
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
            'X',
            'Y',
            'Z',
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
        $this->assertEquals($expected, $result);
    }

    public function primaries_data() {
        return [
            ['X', 1, 0, 0],
            ['Y', 0, 1, 0],
            ['Z', 0, 0, 1],
        ];
    }

    /**
     * @test
     * @dataProvider XYZ_data
     */
    public function identify_returnsCorrectXYZValues($X, $Y, $Z) {
        $colour = new XYZ($X, $Y, $Z);

        $expected = [
            'X' => $X,
            'Y' => $Y,
            'Z' => $Z,
        ];
        $result = $this->colourspace->identify($colour);
        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     * @dataProvider XYZ_data
     */
    public function generate_returnsColourWithCorrectXYZValues($X, $Y, $Z) {
        $colour = $this->colourspace->generate($X, $Y, $Z);

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
        $this->assertEquals($expected, $result);
    }

    public function XYZ_data() {
        return [
            [1.0,       0.0,       0.0],
            [0.0,       1.0,       0.0],
            [0.0,       0.0,       1.0],
            [0.4124564, 0.2126729, 0.0193339],
            [0.3575761, 0.7151522, 0.1191920],
            [0.1804375, 0.0721750, 0.9503041],
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
     * @var XYZColourspace
     */
    private $colourspace;
}
