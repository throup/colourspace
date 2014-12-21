<?php
/**
 * This file contains the RgbColour class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace;

/**
 * Represents a colour in an RGB colourspace
 */
class RgbColour {
    /**
     * Instantiate a colour for the provided RGB representation.
     *
     * @param float $red   The red component of this colour's RGB representation; in the range [0.0–1.0].
     * @param float $green The green component of this colour's RGB representation; in the range [0.0–1.0].
     * @param float $blue  The blue component of this colour's RGB representation; in the range [0.0–1.0].
     */
    public function __construct($red = 0.0, $green = 0.0, $blue = 0.0) {
        $this->red   = (float) $red;
        $this->green = (float) $green;
        $this->blue  = (float) $blue;
    }

    /**
     * Gets the red component of this colour's RGB representation; in the range [0.0–1.0].
     *
     * @return float
     */
    public function getRed() {
        return (float) $this->red;
    }

    /**
     * Gets the green component of this colour's RGB representation; in the range [0.0–1.0].
     *
     * @return float
     */
    public function getGreen() {
        return (float) $this->green;
    }

    /**
     * Gets the blue component of this colour's RGB representation; in the range [0.0–1.0].
     *
     * @return float
     */
    public function getBlue() {
        return (float) $this->blue;
    }

    /**
     * Determine if this colour is equal to another.
     *
     * @param  self $second The other colour to which this one will be compared.
     *
     * @return bool
     */
    public function equals(self $second) {
        return ($this->getRed()   == $second->getRed())
            && ($this->getGreen() == $second->getGreen())
            && ($this->getBlue()  == $second->getBlue());
    }

    /**
     * The red component of this colour's RGB representation; in the range [0.0–1.0].
     *
     * @var float
     */
    private $red   = 0.0;

    /**
     * The green component of this colour's RGB representation; in the range [0.0–1.0].
     *
     * @var float
     */
    private $green = 0.0;

    /**
     * The blue component of this colour's RGB representation; in the range [0.0–1.0].
     *
     * @var float
     */
    private $blue  = 0.0;
}
