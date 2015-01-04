<?php
/**
 * This file contains test cases for the sRGB class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;
use PHPUnit_Framework_TestCase;

/**
 * Tests for the representation of the sRGB colourspace.
 */
class sRGBColourspaceTest extends PHPUnit_Framework_TestCase {
    /**
     * @before
     */
    public function setUp() {
        $this->colourspace = new Space\sRGB();
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
        $colour = new Colour\XYZ($X, $Y, $Z);

        $expected = [
            'R' => $R,
            'G' => $G,
            'B' => $B,
        ];
        $result = $this->colourspace->identify($colour);
        $this->assertEquals($expected, $result, '', 0.0004);
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
     * @test
     */
    public function usableAsSpace() {
        $this->assertIsSpace($this->colourspace);
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
     * Asserts that the variable is an implementation of Space.
     *
     * @param Space $colourspace
     */
    protected function assertIsSpace(Space $colourspace) {
        $colourspace;
    }

    /**
     * @var Space\sRGB
     */
    private $colourspace;

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
