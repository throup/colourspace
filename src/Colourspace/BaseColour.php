<?php
/**
 * This file contains the BaseColour class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

use Colourspace\Matrix\Matrix;

/**
 * Basic representation of a colour.
 */
abstract class BaseColour implements Colour {
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
        $colour = new xyYColour(0.6400, 0.3300, 0.212656);
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
        $colour = new xyYColour(0.3000, 0.6000, 0.715158);
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
        $colour = new xyYColour(0.1500, 0.0600, 0.072186);
        return new Matrix(
            [
                [$colour->getX()],
                [$colour->getY()],
                [$colour->getZ()],
            ]
        );
    }
}
