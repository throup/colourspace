<?php
/**
 * This file contains the Colour interface.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Usecase;

use Colourspace\Colourspace\Space;
use Colourspace\Colourspace\Usecase;

/**
 * Convert a colour from sRGB to XYZ colour spaces.
 */
class sRGB_to_XYZ implements Usecase {
    public function __construct() {
        $this->sRGB = new Space\sRGB();
        $this->XYZ  = new Space\XYZ();
    }

    /**
     * @param array|float[] $input {
     *     @var float $R
     *     @var float $G
     *     @var float $B
     * }
     *
     * @return array|float[] {
     *     @var float $X
     *     @var float $Y
     *     @var float $Z
     * }
     */
    public function execute($input) {
        $colour = $this->sRGB->generate(
            $input['R'] / 255,
            $input['G'] / 255,
            $input['B'] / 255
        );

        return array_map(
            function ($val) {
                return $val * 100;
            },
            $this->XYZ->identify($colour)
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
