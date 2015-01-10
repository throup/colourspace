<?php
/**
 * This file contains the sRGB class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;
use Colourspace\Colourspace\StandardIlluminantFactory;


/**
 * Represents the sRGB colourspace.
 */
class sRGB extends RGB {
    public function __construct() {
        $factory = new StandardIlluminantFactory();
        $xyY     = new Space\xyY();

        $this->referenceWhite = $factory->D(65);
        $this->primaryRed     = $xyY->generate(0.6400, 0.3300, 1);
        $this->primaryGreen   = $xyY->generate(0.3000, 0.6000, 1);
        $this->primaryBlue    = $xyY->generate(0.1500, 0.0600, 1);
    }

    /**
     * Reverses the companding of RGB values; returning them to their linear
     * values.
     *
     * For most RGB colour spaces this will involve applying a gamma curve.
     * For the sRGB colour space we do something a bit funky with the smaller
     * values.
     *
     * @see http://www.brucelindbloom.com/Eqn_RGB_to_XYZ.html
     *
     * @param float $input The companded value.
     *
     * @return float
     */
    protected function inverseCompand($input) {
        if ($input > 0.04045) {
            $output = pow((($input + 0.055) / 1.055), 2.4);
        } else {
            $output = $input / 12.92;
        }
        return $output;
    }

    /**
     * Compands linear RGB values into their "real" values within this colour
     * space.
     *
     * For most RGB colour spaces this will involve applying a gamma curve.
     * For the sRGB colour space we do something a bit funky with the smaller
     * values.
     *
     * @see http://www.brucelindbloom.com/Eqn_XYZ_to_RGB.html
     *
     * @param float $input The value to be companded.
     *
     * @return float
     */
    protected function compand($input) {
        if ($input > 0.0031308) {
            $output = 1.055 * pow($input, 1/2.4) - 0.055;
        } else {
            $output = $input * 12.92;
        }
        return $output;
    }
}
