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
use Colourspace\Colourspace\StandardIlluminantFactory;

/**
 * Represents the XYZ colourspace.
 */
class XYZ extends XYZbased {
    /**
     * @return Colour
     */
    public function whitePoint() {
        $factory = new StandardIlluminantFactory();
        return $factory->E();
    }

    /**
     * @return Colour[]
     */
    public function primaries() {
        return [
            'X' => $this->generate(1, 0, 0),
            'Y' => $this->generate(0, 1, 0),
            'Z' => $this->generate(0, 0, 1),
        ];
    }

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
}
