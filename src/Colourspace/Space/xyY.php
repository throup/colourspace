<?php
/**
 * This file contains the xyY class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;

/**
 * Represents the xyY colourspace.
 */
class xyY extends XYZbased {
    /**
     * @return Colour
     */
    public function whitePoint() {
        return $this->generate(1/3, 1/3, 1);
    }

    /**
     * @param Colour $colour
     * @return float[]
     */
    public function identify(Colour $colour) {
        $sum = $colour->getX() + $colour->getY() + $colour->getZ();
        if ($sum) {
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

        return parent::generate($X, $Y, $Z);
    }

    /**
     * @return string[]
     */
    protected function primaryKeys() {
        return ['x', 'y', 'Y'];
    }
}
