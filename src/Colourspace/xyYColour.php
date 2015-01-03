<?php
/**
 * This file contains the xyYColour class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

/**
 * Class representing a colour in the xyY colourspace.
 */
class xyYColour extends BaseColour {
    private $x = 0.0;
    private $y = 0.0;
    private $Y = 0.0;

    /**
     * @param float $x
     * @param float $y
     * @param float $Y
     */
    public function __construct($x = 0.0, $y = 0.0, $Y = 0.0) {
        $this->x = $x;
        $this->y = $y;
        $this->Y = $Y;
    }

    /**
     * Determine if this colour is equal to another.
     *
     * @param self $second The colour to which this one will be compared.
     *
     * @return bool
     */
    public function equals(Colour $second) {
        return ($this->getX() == $second->getX())
            && ($this->getY() == $second->getY())
            && ($this->getZ() == $second->getZ());
    }

    /**
     * Gets the X component of this colour's XYZ representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getX() {
        return $this->Y * $this->x / $this->y;
    }

    /**
     * Gets the Y component of this colour's XYZ representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getY() {
        return $this->Y;
    }

    /**
     * Gets the Z component of this colour's XYZ representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getZ() {
        return $this->Y * (1 - $this->x - $this->y) / $this->y;
    }

    /**
     * Gets the red component of this colour's RGB representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getRed() {
        $RGB = $this->getRGB();
        return $RGB['R'];
    }

    /**
     * Gets the green component of this colour's XYZ representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getGreen() {
        $RGB = $this->getRGB();
        return $RGB['G'];
    }

    /**
     * Gets the blue component of this colour's XYZ representation; in
     * the range [0.0–1.0].
     *
     * @return float
     */
    public function getBlue() {
        $RGB = $this->getRGB();
        return $RGB['B'];
    }

    /**
     * Calculates the RGB representation for this colour.
     *
     * @return float[]|array {
     *     @var float $R The red component of this colour's RGB
     *                   representation; in the range [0.0–1.0].
     *     @var float $G The green component of this colour's RGB
     *                   representation; in the range [0.0–1.0].
     *     @var float $B The blue component of this colour's RGB
     *                   representation; in the range [0.0–1.0].
     * }
     */
    protected function getRGB() {
        $XYZ = new Matrix(
            [
                [$this->X],
                [$this->Y],
                [$this->Z],
            ]
        );

        $matrix = $this->sRGBinverseMatrix();

        $RGB = $matrix->product($XYZ);

        return [
            'R' => $this->applyGamma($RGB[0][0]),
            'G' => $this->applyGamma($RGB[1][0]),
            'B' => $this->applyGamma($RGB[2][0]),
        ];
    }

    /**
     * Applies the gamma curve appropriate to this XYZ colour space.
     *
     * NB this initial implementation is for the sXYZ space which does
     * something a bit funky with the smaller values. Most XYZ spaces simply
     * apply an exponential factor.
     *
     * @param float $input The value to which the adjustment should be applied.
     *
     * @return float
     */
    protected function applyGamma($input) {
        if ($input > 0.031308) {
            $output = 1.055 * pow($input, 1/2.4) - 0.055;
        } else {
            $output = $input * 12.92;
        }
        return $output;
    }

    /**
     * @return float
     */
    public function get_x() {
        return (float) $this->x;
    }

    /**
     * @return float
     */
    public function get_y() {
        return (float) $this->y;
    }
}
