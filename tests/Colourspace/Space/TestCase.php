<?php
/**
 * This file contains standard tests for any class implementing the
 * {@see \Colourspace\Colourspace\Space} interface.
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
 * Class TestCase
 */
abstract class TestCase extends PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function whitePoint_returnsImplementationOfColour() {
        $this->assertIsColour($this->colourspace->whitePoint());
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
     * @dataProvider whitePoint_data
     */
    public function whitePoint_matchesSpecification($X, $Y, $Z) {
        $whitePoint = $this->colourspace->whitePoint();
        $expected = [
            'X' => $X,
            'Y' => $Y,
            'Z' => $Z,
        ];
        $result = [
            'X' => $whitePoint->getX(),
            'Y' => $whitePoint->getY(),
            'Z' => $whitePoint->getZ(),
        ];
        $this->assertEquals($expected, $result, '', 0.00065);
    }

    /**
     * Expected XYZ values for the colour space white point.
     *
     * @return array {
     *     @var float $X
     *     @var float $Y
     *     @var float $Z
     * }
     */
    abstract public function whitePoint_data();

    /**
     * @test
     */
    public function primaries_returnsArrayContainingThreeItems() {
        $this->assertCount(3, $this->colourspace->primaries());
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
        $this->assertEquals($expected, $result, '', 0.00065);
    }

    /**
     * Expected XYZ values for the colour space primaries.
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
    abstract public function primaries_data();

    /**
     * @test
     * @dataProvider XYZ_data
     */
    public function identify_returnsCorrectValues($X, $Y, $Z, $p1, $p2, $p3) {
        $colour    = new Colour\XYZ($X, $Y, $Z);
        $vals      = [$p1, $p2, $p3];
        $primaries = $this->colourspace->primaries();

        $expected = [];
        foreach (array_keys($primaries) as $i => $key) {
            $expected[$key] = $vals[$i];
        }
        $result = $this->colourspace->identify($colour);

        $this->assertEquals($expected, $result, '', 0.00030017);
    }

    /**
     * @test
     * @dataProvider XYZ_data
     */
    public function generate_returnsColourWithCorrectXYZValues($X, $Y, $Z, $p1, $p2, $p3) {
        $colour = $this->colourspace->generate($p1, $p2, $p3);

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

    /**
     * @test
     * @dataProvider XYZ_data
     */
    public function identify_returnsColourWithValuesUsedToGenerate($X, $Y, $Z, $p1, $p2, $p3) {
        $colour    = $this->colourspace->generate($p1, $p2, $p3);
        $vals      = [$p1, $p2, $p3];
        $primaries = $this->colourspace->primaries();

        $expected = [];
        foreach (array_keys($primaries) as $i => $key) {
            $expected[$key] = $vals[$i];
        }
        $result = $this->colourspace->identify($colour);

        $this->assertEquals($expected, $result);
    }

    /**
     * Expected XYZ values for combinations of the colour space primaries.
     *
     * @return array {
     *     @var array {
     *         @var float  $X
     *         @var float  $Y
     *         @var float  $Z
     *         @var float  $p1
     *         @var float  $p2
     *         @var float  $p3
     *     }
     * }
     */
    abstract public function XYZ_data();

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
     * @var Space
     */
    protected $colourspace;
}
