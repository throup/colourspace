<?php
/**
 * This file contains the sRGB class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;
use Colourspace\Colourspace\StandardIlluminantFactory;
use Colourspace\Matrix\Matrix;

/**
 * Represents the sRGB colourspace.
 */
class sRGB extends XYZbased {
    /**
     * Calculates the RGB representation for this colour.
     *
     * @param Colour $colour
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
    public function identify(Colour $colour) {
        $XYZ = new Matrix(
            [
                [$colour->getX()],
                [$colour->getY()],
                [$colour->getZ()],
            ]
        );

        $matrix = $this->sRGBinverseMatrix();

        $RGB = $matrix->product($XYZ);

        return [
            'R' => $this->applyGamma2($RGB[0][0]),
            'G' => $this->applyGamma2($RGB[1][0]),
            'B' => $this->applyGamma2($RGB[2][0]),
        ];
    }

    /**
     * @param float $R
     * @param float $G
     * @param float $B
     * @return Colour
     */
    public function generate($R, $G, $B) {
        $RGB = new Matrix(
            [
                [$this->applyGamma($R)],
                [$this->applyGamma($G)],
                [$this->applyGamma($B)],
            ]
        );

        $matrix = $this->sRGBmatrix();

        $XYZ = $matrix->product($RGB);
        $X = $XYZ[0][0];
        $Y = $XYZ[1][0];
        $Z = $XYZ[2][0];

        return parent::generate($X, $Y, $Z);
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
        $colourspace = new Space\xyY();
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
        $colourspace = new Space\xyY();
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
        $colourspace = new Space\xyY();
        $colour = $colourspace->generate(0.1500, 0.0600, 1);
        return new Matrix(
            [
                [$colour->getX()],
                [$colour->getY()],
                [$colour->getZ()],
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
    protected function applyGamma2($input) {
        if ($input > 0.031308) {
            $output = 1.055 * pow($input, 1/2.4) - 0.055;
        } else {
            $output = $input * 12.92;
        }
        return $output;
    }

    /**
     * @return string[]
     */
    protected function primaryKeys() {
        return ['R', 'G', 'B'];
    }
}
