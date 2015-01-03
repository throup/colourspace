<?php
/**
 * Colourspace
 * ===========
 * Library to aid the manipulation of colours within different colour spaces
 *
 * Copyright (C) 2014-2015 Chris Throup
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
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
        $colour = new xyYColour(0.6400, 0.3300, 1);
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
        $colour = new xyYColour(0.3000, 0.6000, 1);
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
        $colour = new xyYColour(0.1500, 0.0600, 1);
        return new Matrix(
            [
                [$colour->getX()],
                [$colour->getY()],
                [$colour->getZ()],
            ]
        );
    }
}
