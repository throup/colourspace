<?php
/**
 * This file contains the XYZ class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Colour;

use Colourspace\Colourspace\Colour;

/**
 * Represents a colour in an XYZ colourspace
 */
class XYZ implements Colour {
    /**
     * Instantiate a colour for the provided XYZ representation.
     *
     * @param float $X The X component of this colour's XYZ representation; in
     *                 the range [0.0–1.0].
     * @param float $Y The Y component of this colour's XYZ representation; in
     *                 the range [0.0–1.0].
     * @param float $Z The Z component of this colour's XYZ representation; in
     *                 the range [0.0–1.0].
     */
    public function __construct($X = 0.0, $Y = 0.0, $Z = 0.0) {
        $this->X = (float) $X;
        $this->Y = (float) $Y;
        $this->Z = (float) $Z;
    }

    /**
     * Determine if this colour is equal to another.
     *
     * @param Colour $second The colour to which this one will be compared.
     *
     * @return bool
     */
    public function equals(Colour $second) {
        return ($this->getX() == $second->getX())
            && ($this->getY() == $second->getY())
            && ($this->getZ() == $second->getZ());
    }

    /**
     * Gets the X component of this colour's XYZ representation; in the
     * range [0.0–1.0].
     *
     * @return float
     */
    public function getX() {
        return (float) $this->X;
    }

    /**
     * Gets the Y component of this colour's XYZ representation; in the
     * range [0.0–1.0].
     *
     * @return float
     */
    public function getY() {
        return (float) $this->Y;
    }

    /**
     * Gets the Z component of this colour's XYZ representation; in the
     * range [0.0–1.0].
     *
     * @return float
     */
    public function getZ() {
        return (float) $this->Z;
    }

    /**
     * The X component of this colour's XYZ representation; in the
     * range [0.0–1.0].
     *
     * @var float
     */
    private $X   = 0.0;

    /**
     * The Y component of this colour's XYZ representation; in the
     * range [0.0–1.0].
     *
     * @var float
     */
    private $Y = 0.0;

    /**
     * The Z component of this colour's XYZ representation; in the
     * range [0.0–1.0].
     *
     * @var float
     */
    private $Z  = 0.0;
}
