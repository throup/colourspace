<?php
/**
 * This file contains the xyYColourspace class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

/**
 * Represents the xyY colourspace.
 */
class xyYColourspace {
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
            'x' => new xyYColour(1, 0, 0),
            'y' => new xyYColour(0, 1, 0),
            'Y' => new xyYColour(0, 0, 1),
        ];
    }

    /**
     * @param Colour $colour
     * @return float[]
     */
    public function identify(Colour $colour) {
        if ($sum = $colour->getX() + $colour->getY() + $colour->getZ()) {
            return [
                'x' => $colour->getX() / $sum,
                'y' => $colour->getY() / $sum,
                'Y' => $colour->getY(),
            ];
        } else {
            $white = $this->identify($this->whitePoint());
            return [
                'x' => $white['x'],
                'y' => $white['y'],
                'Y' => 0,
            ];
        }
    }

    /**
     * @param float $x
     * @param float $y
     * @param float $Y
     * @return Colour
     */
    public function generate($x, $y, $Y) {
        return new xyYColour($x, $y, $Y);
    }
}
