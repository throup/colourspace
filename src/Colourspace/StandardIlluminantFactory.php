<?php
/**
 * This file contains the StandardIlluminantFactory class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

/**
 * Factory for colours representing standard illuminants.
 */
class StandardIlluminantFactory {
    /**
     * Create an illuminant from the CIE D-series.
     *
     * @param int $temp The particular illuminant from the series.
     *
     * @return Colour
     */
    public function D($temp) {
        $T = $temp * 100 * 14388 / 14380;

        $x = 0.244063
           + 0.099110 * pow(10, 3) / $T
           + 2.967800 * pow(10, 6) / pow($T, 2)
           - 4.607000 * pow(10, 9) / pow($T, 3);
        $y = 2.870 * $x - 3.000 * pow($x, 2) - 0.275;

        $Y = 1;
        $X = $Y * $x / $y;
        $Z = $Y * (1 - $x - $y) / $y;

        return new XyzColour($X, $Y, $Z);
    }
}
