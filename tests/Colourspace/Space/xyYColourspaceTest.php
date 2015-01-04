<?php
/**
 * This file contains test cases for the xyY class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;
use PHPUnit_Framework_TestCase;

/**
 * Tests for the representation of the xyY colourspace.
 */
class xyYColourspaceTest extends PHPUnit_Framework_TestCase {
    /**
     * @before
     */
    public function setUp() {
        $this->colourspace = new Space\xyY();
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
    public function primaries_keysAre_xyY_() {
        $expected = [
            'x',
            'y',
            'Y',
        ];
        $keys = array_keys($this->colourspace->primaries());
        $this->assertEquals($expected, $keys);
    }

    /**
     * @test
     * @dataProvider primaries_data
     * @param $primary
     * @param $X
     * @param $Y
     * @param $Z
     * @param $x
     * @param $y
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

    /**
     * Expected XYZ values for the colour space primaries.
     *
     * NB technically (small) y is undefined because it could only have a value
     * if (big) Y does too.
     *
     * @return array {
     *     @var array {
     *         @var string $primary
     *         @var float  $X
     *         @var float  $Y
     *         @var float  $Z
     *     }
     * }
     */
    public function primaries_data() {
        return [
            ['x', 1, 0, 0],
            ['y', 0, 0, 0],
            ['Y', 0, 1, 0],
        ];
    }

    /**
     * @test
     * @dataProvider XYZtoxyY_data
     */
    public function identify_returnsCorrectxyYValues($X, $Y, $Z, $x, $y) {
        $colour = new Colour\XYZ($X, $Y, $Z);

        $expected = [
            'x' => $x,
            'y' => $y,
            'Y' => $Y,
        ];
        $result = $this->colourspace->identify($colour);
        $this->assertEquals($expected, $result, '', 0.0000001);
    }

    /**
     * @test
     * @dataProvider XYZtoxyY_data
     */
    public function generate_returnsColourWithCorrectXYZValues($X, $Y, $Z, $x, $y) {
        $colour = $this->colourspace->generate($x, $y, $Y);

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
        $this->assertEquals($expected, $result, '', 0.000001);
    }

    public function XYZtoxyY_data() {
        return [
            [1.0,       0.0,       0.0,       1.0   , 0.0   ],
            [0.0,       1.0,       0.0,       0.0   , 1.0   ],
            [0.0,       0.0,       1.0,       0.0   , 0.0   ],
            [0.4124564, 0.2126729, 0.0193339, 0.6400, 0.3300],
            [0.3575761, 0.7151522, 0.1191920, 0.3000, 0.6000],
            [0.1804375, 0.0721750, 0.9503041, 0.1500, 0.0600],
            [0.0,       0.0,       0.0,       1/3   , 1/3   ],
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
     * @var Space\xyY
     */
    private $colourspace;

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

        $colourspace = new Space\xyY();
        $xyY = $colourspace->identify($colour);

        $this->assertEquals($x, $xyY['x']);
        $this->assertEquals($y, $xyY['y']);
        $this->assertEquals($Y, $xyY['Y']);
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

    /*
     * Generate a testable colour object for the provided xyY representation.
     *
     * @param float $x The x component of this colour's xyY representation; in
     *                 the range [0.0–1.0].
     * @param float $y The (little) y component of this colour's xyY
     *                 representation; in the range [0.0–1.0].
     * @param float $Y The (big) Y component of this colour's xyY
     *                 representation; in the range [0.0–1.0].
     *
     * @return Colour
     */
    protected function generate_xyYColour($x = 0.0,
                                          $y = 0.0,
                                          $Y = 0.0) {
        $colourspace = new Space\xyY();
        return $colourspace->generate($x, $y, $Y);
    }
}
