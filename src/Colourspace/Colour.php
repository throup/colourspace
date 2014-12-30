<?php
/**
 * This file contains the Colour interface.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

/**
 * Represents a colour in an RGB colourspace
 */
interface Colour {
    /**
     * Determine if this colour is equal to another.
     *
     * @param self $second The colour to which this one will be compared.
     *
     * @return bool
     */
    public function equals(self $second);

    /**
     * Gets the X component of this colour's XYZ representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getX();

    /**
     * Gets the Y component of this colour's XYZ representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getY();

    /**
     * Gets the Z component of this colour's XYZ representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getZ();

    /**
     * Gets the red component of this colour's RGB representation; in the
     * range [0.0–1.0].
     *
     * @return float
     */
    public function getRed();

    /**
     * Gets the green component of this colour's RGB representation; in the
     * range [0.0–1.0].
     *
     * @return float
     */
    public function getGreen();

    /**
     * Gets the blue component of this colour's RGB representation; in the
     * range [0.0–1.0].
     *
     * @return float
     */
    public function getBlue();
}
