<?php
/**
 * This file contains the XYZ class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;

/**
 * Represents the XYZ colourspace.
 */
class XYZ extends XYZbased {
    /**
     * @param Colour $colour
     * @return float[]
     */
    public function identify(Colour $colour) {
        return [
            'X' => $colour->getX(),
            'Y' => $colour->getY(),
            'Z' => $colour->getZ(),
        ];
    }

    /**
     * @return string[]
     */
    protected function primaryKeys() {
        return $keys = ['X', 'Y', 'Z'];
    }
}
