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

/**
 * Convert a colour from sRGB to XYZ colour spaces.
 */
class sRGB_to_XYZ {
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
        $R = $input['R'] / 255;
        $G = $input['G'] / 255;
        $B = $input['B'] / 255;

        $colourspace = new Space\sRGB();
        $colour = $colourspace->generate($R, $G, $B);

        return [
            'X' => $colour->getX() * 100,
            'Y' => $colour->getY() * 100,
            'Z' => $colour->getZ() * 100,
        ];
    }
}
