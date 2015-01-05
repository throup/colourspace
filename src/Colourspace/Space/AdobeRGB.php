<?php
/**
 * This file contains the AdobeRGB class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;
use Colourspace\Colourspace\StandardIlluminantFactory;
use Colourspace\Matrix\Matrix;

/**
 * Represents the AdobeRGB colourspace.
 */
class AdobeRGB extends RGB {
    public function __construct() {
        $factory = new StandardIlluminantFactory();
        $xyY     = new Space\xyY();

        $this->referenceWhite = $factory->D(65);
        $this->primaryRed     = $xyY->generate(0.6400, 0.3300, 1);
        $this->primaryGreen   = $xyY->generate(0.2100, 0.7100, 1);
        $this->primaryBlue    = $xyY->generate(0.1500, 0.0600, 1);
        $this->gamma          = 563/256;
    }

    /**
     * Reverses the companding of RGB values; returning them to their linear
     * values.
     *
     * For the AdobeRGB colour spaces this involves applying a gamma curve.
     *
     * @see http://www.brucelindbloom.com/Eqn_RGB_to_XYZ.html
     *
     * @param float $input The companded value.
     *
     * @return float
     */
    protected function inverseCompand($input) {
        return pow($input, $this->gamma);
    }

    /**
     * Compands linear RGB values into their "real" values within this colour
     * space.
     *
     * For the AdobeRGB colour spaces this involves applying a gamma curve.
     *
     * @see http://www.brucelindbloom.com/Eqn_XYZ_to_RGB.html
     *
     * @param float $input The value to be companded.
     *
     * @return float
     */
    protected function compand($input) {
        if ($input > 0) {
            return pow($input, 1 / $this->gamma);
        } else {
            return 0;
        }
    }

    /**
     * @var float The exponent used for companding linear values.
     */
    private $gamma;
}
