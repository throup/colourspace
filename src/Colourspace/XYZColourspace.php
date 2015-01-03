<?php
/**
 * This file contains the XYZColourspace class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

/**
 * Represents the XYZ colourspace.
 */
class XYZColourspace {
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
            'X' => new XyzColour(1, 0, 0),
            'Y' => new XyzColour(0, 1, 0),
            'Z' => new XyzColour(0, 0, 1),
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

    /**
     * @param float $X
     * @param float $Y
     * @param float $Z
     * @return Colour
     */
    public function generate($X, $Y, $Z) {
        return new XyzColour($X, $Y, $Z);
    }
}
