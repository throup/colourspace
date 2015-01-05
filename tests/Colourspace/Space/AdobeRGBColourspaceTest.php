<?php
/**
 * This file contains test cases for the AdobeRGB class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;

/**
 * Tests for the representation of the AdobeRGB colourspace.
 *
 * @see http://www.brucelindbloom.com/ColorCalculator.html
 */
class AdobeRGBColourspaceTest extends TestCase {
    /**
     * @before
     */
    public function setUp() {
        $this->colourspace = new Space\AdobeRGB();
        parent::setUp();
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
    public function whitePoint_data() {
        return [
            [
                'X' => 0.95047,
                'Y' => 1.00000,
                'Z' => 1.08883,
            ]
        ];
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
    public function primaries_data() {
        return [
            ['R', 0.576731, 0.297377, 0.027034],
            ['G', 0.185554, 0.627349, 0.070687],
            ['B', 0.188185, 0.075274, 0.991109],
        ];
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
    public function XYZ_data() {
        return [
        //   X         Y         Z         R    G    B
            [0.576731, 0.297377, 0.027034, 1.0, 0.0, 0.0],
            [0.185554, 0.627349, 0.070687, 0.0, 1.0, 0.0],
            [0.188185, 0.075274, 0.991109, 0.0, 0.0, 1.0],
        ];
    }
}
