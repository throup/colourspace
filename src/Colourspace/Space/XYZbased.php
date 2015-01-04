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
     * @return Colour[]
     */
    public function primaries() {
        $colours = [
            $this->generate(1, 0, 0),
            $this->generate(0, 1, 0),
            $this->generate(0, 0, 1),
        ];

        $primaries = [];
        foreach ($this->primaryKeys() as $i => $key) {
            $primaries[$key] = $colours[$i];
        }
        return $primaries;
    }

    /**
     * @return string[]
     */
    abstract protected function primaryKeys();

    /**
     * @param float $X
     * @param float $Y
     * @param float $Z
     * @return Colour
     */
    public function generate($X, $Y, $Z) {
        return new Colour\XYZ($X, $Y, $Z);
    }

    /**
     * @return Colour
     */
    public function whitePoint() {
        return $this->generate(1, 1, 1);
    }
}
