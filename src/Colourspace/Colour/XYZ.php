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
use Colourspace\Colourspace\StandardIlluminantFactory;
use Colourspace\Colourspace\xyYColourspace;
use Colourspace\Matrix\Matrix;

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

    /**
     * Returns the standard sRGB transformation matrix.
     *
     * @return Matrix
     */
    protected function sRGBmatrix() {
        $W = $this->referenceWhite();
        $R = $this->primaryRed();
        $G = $this->primaryGreen();
        $B = $this->primaryBlue();


        $colours = new Matrix(
            [
                [$R[0][0], $G[0][0], $B[0][0]],
                [$R[1][0], $G[1][0], $B[1][0]],
                [$R[2][0], $G[2][0], $B[2][0]],
            ]
        );

        $coloursI = $colours->inverse();

        $S = $coloursI->product($W);

        return new Matrix(
            [
                [$S[0][0] * $R[0][0], $S[1][0] * $G[0][0], $S[2][0] * $B[0][0]],
                [$S[0][0] * $R[1][0], $S[1][0] * $G[1][0], $S[2][0] * $B[1][0]],
                [$S[0][0] * $R[2][0], $S[1][0] * $G[2][0], $S[2][0] * $B[2][0]],
            ]
        );
    }

    /**
     * Returns the inverse of the standard sRGB transformation matrix.
     *
     * @return Matrix
     */
    protected function sRGBinverseMatrix() {
        $matrix = $this->sRGBmatrix();
        return $matrix->inverse();
    }

    /**
     * @return Matrix
     */
    protected function referenceWhite() {
        $factory = new StandardIlluminantFactory();
        $illuminant = $factory->D(65);

        return new Matrix(
            [
                [$illuminant->getX()],
                [$illuminant->getY()],
                [$illuminant->getZ()],
            ]
        );
    }

    /**
     * @return Matrix
     */
    protected function primaryRed() {
        $colourspace = new xyYColourspace();
        $colour = $colourspace->generate(0.6400, 0.3300, 1);
        return new Matrix(
            [
                [$colour->getX()],
                [$colour->getY()],
                [$colour->getZ()],
            ]
        );
    }

    /**
     * @return Matrix
     */
    protected function primaryGreen() {
        $colourspace = new xyYColourspace();
        $colour = $colourspace->generate(0.3000, 0.6000, 1);
        return new Matrix(
            [
                [$colour->getX()],
                [$colour->getY()],
                [$colour->getZ()],
            ]
        );
    }

    /**
     * @return Matrix
     */
    protected function primaryBlue() {
        $colourspace = new xyYColourspace();
        $colour = $colourspace->generate(0.1500, 0.0600, 1);
        return new Matrix(
            [
                [$colour->getX()],
                [$colour->getY()],
                [$colour->getZ()],
            ]
        );
    }
}
