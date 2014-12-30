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
        $x = 0.31271;
        $y = 0.32902;
        $Y = 1;
        $W = new Matrix(
            [
                [$Y * $x / $y],
                [$Y],
                [$Y * (1 - $x - $y) / $y,]
            ]
        );
        return $W;
    }

    /**
     * @return Matrix
     */
    protected function primaryRed() {
        $x = 0.6400;
        $y = 0.3300;
        $Y = 0.212656;
        $R = new Matrix(
            [
                [$Y * $x / $y],
                [$Y],
                [$Y * (1 - $x - $y) / $y,]
            ]
        );
        return $R;
    }

    /**
     * @return Matrix
     */
    protected function primaryGreen() {
        $x = 0.3000;
        $y = 0.6000;
        $Y = 0.715158;
        $G = new Matrix(
            [
                [$Y * $x / $y],
                [$Y],
                [$Y * (1 - $x - $y) / $y,]
            ]
        );
        return $G;
    }

    /**
     * @return Matrix
     */
    protected function primaryBlue() {
        $x = 0.1500;
        $y = 0.0600;
        $Y = 0.072186;
        $B = new Matrix(
            [
                [$Y * $x / $y],
                [$Y],
                [$Y * (1 - $x - $y) / $y,]
            ]
        );
        return $B;
    }
}
