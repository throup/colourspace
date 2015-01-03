<?php
/**
 * This file contains test cases for the StandardIlluminantFactory class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

use PHPUnit_Framework_TestCase;

/**
 * Class StandardIlluminantFactoryTest
 */
class StandardIlluminantFactoryTest extends PHPUnit_Framework_TestCase {
    /**
     * Acceptable accuracy for floating point comparison.
     *
     * Weird value, I know! There are a number of definitions floating around
     * on the 'net, so this is the accuracy I can achieve with my initial
     * implementation. I would hope to improve this in time, but I certainly
     * don't want this gap to increase.
     */
    const DELTA = 0.00125; // That is 1 in 800.

    /**
     * @test
     */
    public function DReturnsImplementationOfColour() {
        $factory = new StandardIlluminantFactory();
        $illuminant = $factory->D(65);
        $f = function(Colour $colour) {
            $colour;
        };
        $f($illuminant);
    }

    /**
     * @test
     * @dataProvider DMatches_data
     */
    public function DMatchesDefinedStandard($D, $X, $Y, $Z) {
        $factory = new StandardIlluminantFactory();
        $illuminant = $factory->D($D);
        $this->assertEquals($X, $illuminant->getX(), '', self::DELTA);
        $this->assertEquals($Y, $illuminant->getY(), '', self::DELTA);
        $this->assertEquals($Z, $illuminant->getZ(), '', self::DELTA);
    }

    public function DMatches_data() {
        return [
            [50, 0.96422, 1.00000, 0.82521],
            [55, 0.95682, 1.00000, 0.92149],
            [65, 0.95047, 1.00000, 1.08883],
            [75, 0.94972, 1.00000, 1.22638],
        ];
    }

    /**
     * @test
     */
    public function EReturnsImplementationOfColour() {
        $factory = new StandardIlluminantFactory();
        $illuminant = $factory->E();
        $f = function(Colour $colour) {
            $colour;
        };
        $f($illuminant);
    }

    /**
     * @test
     */
    public function EMatchesDefinedStandard() {
        $factory = new StandardIlluminantFactory();
        $illuminant = $factory->E();
        $this->assertEquals(1, $illuminant->getX(), '', self::DELTA);
        $this->assertEquals(1, $illuminant->getY(), '', self::DELTA);
        $this->assertEquals(1, $illuminant->getZ(), '', self::DELTA);
    }
}
