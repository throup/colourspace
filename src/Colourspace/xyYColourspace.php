<?php
/**
 * This file contains the xyYColourspace class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

use Colourspace\Colourspace\Colour\XYZ;

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
            'x' => $this->generate(1, 0, 0),
            'y' => $this->generate(0, 1, 0),
            'Y' => $this->generate(0, 0, 1),
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
        if ($y) {
            $X = $Y * $x / $y;
        } else if (!$Y) {
            $X = $x;
        } else {
            $X = 0;
        }

        if ($y) {
            $Z = $Y * (1 - $x - $y) / $y;
        } else if (!$x && !$Y) {
            $Z = 1;
        } else {
            $Z = 0;
        }


        return new XYZ($X, $Y, $Z);
    }
}
