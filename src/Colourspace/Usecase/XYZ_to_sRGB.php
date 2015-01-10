<?php
/**
 * This file contains the XYZ to sRGB use case.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Usecase;

use Colourspace\Colourspace\Space;
use Colourspace\Colourspace\Usecase;

/**
 * Convert a colour from XYZ to sRGB colour spaces.
 */
class XYZ_to_sRGB implements Usecase {
    public function __construct() {
        $this->sRGB = new Space\sRGB();
        $this->XYZ  = new Space\XYZ();
    }

    /**
     * @param array|float[] $input {
     *     @var float $X
     *     @var float $Y
     *     @var float $Z
     * }
     *
     * @return array|float[] {
     *     @var float $R
     *     @var float $G
     *     @var float $B
     * }
     */
    public function execute($input) {
        $colour = $this->XYZ->generate(
            $input['X'] / 100,
            $input['Y'] / 100,
            $input['Z'] / 100
        );

        return array_map(
            function ($val) {
                return $val * 255;
            },
            $this->sRGB->identify($colour)
        );
    }

    /**
     * @var Space\sRGB
     */
    private $sRGB;

    /**
     * @var Space\XYZ
     */
    private $XYZ;
}
