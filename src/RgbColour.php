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
     * @param float $red   The red component of this colour's RGB
     *                     representation; in the range [0.0–1.0].
     * @param float $green The green component of this colour's RGB
     *                     representation; in the range [0.0–1.0].
     * @param float $blue  The blue component of this colour's RGB
     *                     representation; in the range [0.0–1.0].
     */
    public function __construct($red = 0.0, $green = 0.0, $blue = 0.0) {
        $this->red   = (float) $red;
        $this->green = (float) $green;
        $this->blue  = (float) $blue;
    }

    /**
     * Gets the red component of this colour's RGB representation; in the
     * range [0.0–1.0].
     *
     * @return float
     */
    public function getRed() {
        return (float) $this->red;
    }

    /**
     * Gets the green component of this colour's RGB representation; in the
     * range [0.0–1.0].
     *
     * @return float
     */
    public function getGreen() {
        return (float) $this->green;
    }

    /**
     * Gets the blue component of this colour's RGB representation; in the
     * range [0.0–1.0].
     *
     * @return float
     */
    public function getBlue() {
        return (float) $this->blue;
    }

    /**
     * Determine if this colour is equal to another.
     *
     * @param self $second The other colour to which this one will be compared.
     *
     * @return bool
     */
    public function equals(self $second) {
        return ($this->getRed()   == $second->getRed())
            && ($this->getGreen() == $second->getGreen())
            && ($this->getBlue()  == $second->getBlue());
    }

    /**
     * The red component of this colour's RGB representation; in the
     * range [0.0–1.0].
     *
     * @var float
     */
    private $red   = 0.0;

    /**
     * The green component of this colour's RGB representation; in the
     * range [0.0–1.0].
     *
     * @var float
     */
    private $green = 0.0;

    /**
     * The blue component of this colour's RGB representation; in the
     * range [0.0–1.0].
     *
     * @var float
     */
    private $blue  = 0.0;

    /**
     * Gets the X component of this colour's XYZ representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getX() {
        $XYZ = $this->getXYZ();
        return $XYZ['X'];
    }

    /**
     * Gets the Y component of this colour's XYZ representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getY() {
        $XYZ = $this->getXYZ();
        return $XYZ['Y'];
    }

    /**
     * Gets the Z component of this colour's XYZ representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getZ() {
        $XYZ = $this->getXYZ();
        return $XYZ['Z'];
    }

    /**
     * Calculates the XYZ representation for this colour.
     *
     * @return float[]|array {
     *     @var float $X The X component of this colour's XYZ representation;
     *                   in the range [0.0–1.0].
     *     @var float $Y The Y component of this colour's XYZ representation;
     *                   in the range [0.0–1.0].
     *     @var float $Z The Z component of this colour's XYZ representation;
     *                   in the range [0.0–1.0].
     * }
     */
    protected function getXYZ() {
        $R = $this->applyGamma($this->red);
        $G = $this->applyGamma($this->green);
        $B = $this->applyGamma($this->blue);

        $X = $R * 0.4124 + $G * 0.3576 + $B * 0.1805;
        $Y = $R * 0.2126 + $G * 0.7152 + $B * 0.0722;
        $Z = $R * 0.0193 + $G * 0.1192 + $B * 0.9505;

        return [
            'X' => $X,
            'Y' => $Y,
            'Z' => $Z,
        ];
    }

    /**
     * Applies the gamma curve appropriate to this RGB colour space.
     *
     * NB this initial implementation is for the sRGB space which does
     * something a bit funky with the smaller values. Most RGB spaces simply
     * apply an exponential factor.
     *
     * @param float $input The value to which the adjustment should be applied.
     *
     * @return float
     */
    protected function applyGamma($input) {
        if ($input > 0.04045) {
            $output = pow((($input + 0.055) / 1.055), 2.4);
        } else {
            $output = $input / 12.92;
        }
        return $output;
    }
}
