<?php
/**
 * This file contains the RgbColour class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

use Colourspace\Matrix\Matrix;

/**
 * Represents a colour in an RGB colourspace
 */
class RgbColour extends BaseColour {
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
     * Determine if this colour is equal to another.
     *
     * @param Colour $second The colour to which this one will be compared.
     *
     * @return bool
     */
    public function equals(Colour $second) {
        return ($this->getRed()   == $second->getRed())
               && ($this->getGreen() == $second->getGreen())
               && ($this->getBlue()  == $second->getBlue());
    }

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
        $RGB = new Matrix(
            [
                [$this->applyGamma($this->red)],
                [$this->applyGamma($this->green)],
                [$this->applyGamma($this->blue)],
            ]
        );

        $matrix = $this->sRGBmatrix();

        $XYZ = $matrix->product($RGB);

        return [
            'X' => $XYZ[0][0],
            'Y' => $XYZ[1][0],
            'Z' => $XYZ[2][0],
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
}
