<?php
/**
 * This file contains test cases for the XYZ_to_sRGB class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Usecase;

use PHPUnit_Framework_TestCase;

/**
 * Class XYZ_to_sRGBTest
 */
class XYZ_to_sRGBTest extends PHPUnit_Framework_TestCase {
    /**
     * @before
     */
    public function setUp() {
        $this->usecase = new XYZ_to_sRGB();
        parent::setUp();
    }

    /**
     * @test
     * @dataProvider XYZ_data
     */
    public function executeReturnsExpectedData($X, $Y, $Z, $R, $G, $B) {
        $expected = [
            'R' => $R,
            'G' => $G,
            'B' => $B,
        ];

        $input = [
            'X' => $X,
            'Y' => $Y,
            'Z' => $Z,
        ];
        $output = $this->usecase->execute($input);

        $this->assertEquals($expected, $output, '', 0.08);
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
     * @var XYZ_to_sRGB
     */
    private $usecase;
}
