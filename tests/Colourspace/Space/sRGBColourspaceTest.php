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

/**
 * Tests for the representation of the sRGB colourspace.
 */
class sRGBColourspaceTest extends TestCase {
    /**
     * @before
     */
    public function setUp() {
        $this->colourspace = new Space\sRGB();
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
            ['R', 0.412423758, 0.2126560, 0.019332364],
            ['G', 0.3575761,   0.7151522, 0.1191920],
            ['B', 0.1804375,   0.0721750, 0.9503041],
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
        //   X            Y          Z            R    G    B
            [0.412423758, 0.2126560, 0.019332364, 1.0, 0.0, 0.0],
            [0.3575761,   0.7151522, 0.1191920,   0.0, 1.0, 0.0],
            [0.1804375,   0.0721750, 0.9503041,   0.0, 0.0, 1.0],
        ];
    }
}
