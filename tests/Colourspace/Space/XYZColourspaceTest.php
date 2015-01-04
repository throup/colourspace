<?php
/**
 * This file contains test cases for the XYZ class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;

/**
 * Tests for the representation of the XYZ colourspace.
 */
class XYZColourspaceTest extends \Colourspace\Colourspace\Space\TestCase {
    /**
     * @before
     */
    public function setUp() {
        $this->colourspace = new Space\XYZ();
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
                'X' => 1,
                'Y' => 1,
                'Z' => 1,
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
            ['X', 1, 0, 0],
            ['Y', 0, 1, 0],
            ['Z', 0, 0, 1],
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
        //   X          Y          Z          X(1)       Y(1)       Z(1)
            [1.0,       0.0,       0.0,       1.0,       0.0,       0.0],
            [0.0,       1.0,       0.0,       0.0,       1.0,       0.0],
            [0.0,       0.0,       1.0,       0.0,       0.0,       1.0],
            [0.4124564, 0.2126729, 0.0193339, 0.4124564, 0.2126729, 0.0193339],
            [0.3575761, 0.7151522, 0.1191920, 0.3575761, 0.7151522, 0.1191920],
            [0.1804375, 0.0721750, 0.9503041, 0.1804375, 0.0721750, 0.9503041],
        ];
    }
}
