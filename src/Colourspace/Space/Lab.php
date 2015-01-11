<?php
/**
 * This file contains the Lab class.
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
 * Represents the Lab colourspace.
 */
class Lab extends XYZbased {
    public function __construct() {
        $factory = new StandardIlluminantFactory();

        $this->referenceWhite = $factory->D(65);
    }

    /**
     * @param Colour $colour
     * @return float[]
     */
    public function identify(Colour $colour) {
        $L = 116 * $this->fy($colour) - 16;
        $a = 500 * ($this->fx($colour) - $this->fy($colour));
        $b = 200 * ($this->fy($colour) - $this->fz($colour));
        return [
            'L' => $L,
            'a' => $a,
            'b' => $b,
        ];
    }

    /**
     * @return string[]
     */
    protected function primaryKeys() {
        return ['L', 'a', 'b'];
    }

    private function fx(Colour $colour) {
        return $this->f($this->xr($colour));
    }

    private function fy(Colour $colour) {
        return $this->f($this->yr($colour));
    }

    private function fz(Colour $colour) {
        return $this->f($this->zr($colour));
    }

    const K = 24389/27;
    const E = 216/24389;

    /**
     * @param $r
     * @return float|number
     */
    private function f($r) {
        if ($r > self::E) {
            return pow($r, 1 / 3);
        } else {
            return (self::K * $r + 16) / 116;
        }
    }

    private function xr(Colour $colour) {
        return $colour->getX() / $this->referenceWhite->getX();
    }

    private function yr(Colour $colour) {
        return $colour->getY() / $this->referenceWhite->getY();
    }

    private function zr(Colour $colour) {
        return $colour->getZ() / $this->referenceWhite->getZ();
    }
}
