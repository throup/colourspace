<?php
/**
 * This file contains the sRGBColourspace class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

/**
 * Represents the sRGB colourspace.
 */
class sRGBColourspace {
    /**
     * @return Colour
     */
    public function whitePoint() {
        $factory = new StandardIlluminantFactory();
        return $factory->D(65);
    }

    /**
     * @return Colour[]
     */
    public function primaries() {
        return [
            'R' => new xyYColour(0.6400, 0.3300, 0.212656),
            'G' => new xyYColour(0.3000, 0.6000, 0.715158),
            'B' => new xyYColour(0.1500, 0.0600, 0.072186),
        ];
    }

    /**
     * @param Colour $colour
     * @return float[]
     */
    public function identify(Colour $colour) {
        return [
            'R' => $colour->getRed(),
            'G' => $colour->getGreen(),
            'B' => $colour->getBlue(),
        ];
    }

    /**
     * @param float $R
     * @param float $G
     * @param float $B
     * @return Colour
     */
    public function generate($R, $G, $B) {
        return new RgbColour($R, $G, $B);
    }
}
