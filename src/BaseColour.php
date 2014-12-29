<?php
/**
 * This file contains the BaseColour class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace;

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
        return new Matrix(
            [
                [0.4124564, 0.3575761, 0.1804375],
                [0.2126729, 0.7151522, 0.0721750],
                [0.0193339, 0.1191920, 0.9503041],
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
}
