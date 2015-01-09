<?php
/**
 * This file contains test cases for the sRGB_to_XYZ class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Usecase;

use PHPUnit_Framework_TestCase;

/**
 * Class sRGB_to_XYZTest
 */
class sRGB_to_XYZTest extends PHPUnit_Framework_TestCase {
    /**
     * @before
     */
    public function setUp() {
        $this->usecase = new sRGB_to_XYZ();
        parent::setUp();
    }

    /**
     * @test
     * @dataProvider XYZ_data
     */
    public function executeReturnsExpectedData($X, $Y, $Z, $R, $G, $B) {
        $expected = [
            'X' => $X,
            'Y' => $Y,
            'Z' => $Z,
        ];

        $input = [
            'R' => $R,
            'G' => $G,
            'B' => $B,
        ];
        $output = $this->usecase->execute($input);

        $this->assertEquals($expected, $output, '', 0.065);
    }

    public function XYZ_data() {
        return [
        //   X         Y         Z         R    G    B
            [ 41.2456,  21.2673,   1.9334, 255,   0,   0],
            [ 35.7576,  71.5152,  11.9192,   0, 255,   0],
            [ 18.0437,   7.2175,  95.0304,   0,   0, 255],
            [ 95.047,  100.000,  108.883,  255, 255, 255],
            [ 56.064,   50.490,    8.157,  255, 171,  32],
            [ 11.615,   16.997,   23.091,    0, 128, 128],
        ];
    }

    /**
     * @var sRGB_to_XYZ
     */
    private $usecase;
}
