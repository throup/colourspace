<?php
/**
 * This file contains the XYZbased class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;

/**
 * Class XYZbased
 */
abstract class XYZbased implements Space {
    /**
     * @param float $X
     * @param float $Y
     * @param float $Z
     * @return Colour
     */
    public function generate($X, $Y, $Z) {
        return new Colour\XYZ($X, $Y, $Z);
    }
}
