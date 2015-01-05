<?php
/**
 * This file contains the RGB class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Matrix\Matrix;
use Colourspace\Colourspace\Colour;

/**
 * Represents an additive RGB colourspace.
 */
abstract class RGB extends XYZbased {
    /**
     * @param float $R
     * @param float $G
     * @param float $B
     * @return Colour
     */
    public function generate($R, $G, $B) {
        $RGB = new Matrix(
            [
                [$this->inverseCompand($R)],
                [$this->inverseCompand($G)],
                [$this->inverseCompand($B)],
            ]
        );

        $matrix = $this->transformationMatrix();

        $XYZ = $matrix->product($RGB);
        $X = $XYZ->entry(1);
        $Y = $XYZ->entry(2);
        $Z = $XYZ->entry(3);

        return parent::generate($X, $Y, $Z);
    }

    /**
     * Reverses the companding of RGB values; returning them to their linear
     * values.
     *
     * For most RGB colour spaces this will involve applying a gamma curve.
     *
     * @param float $input The companded value.
     *
     * @return float
     */
    abstract protected function inverseCompand($input);

    /**
     * Returns the transformation matrix for this colour space.
     *
     * @return Matrix
     */
    protected function transformationMatrix() {
        $W = $this->colourAsMatrix($this->referenceWhite);
        $R = $this->colourAsMatrix($this->primaryRed);
        $G = $this->colourAsMatrix($this->primaryGreen);
        $B = $this->colourAsMatrix($this->primaryBlue);


        $colours = new Matrix(
            [
                [$R->entry(1), $G->entry(1), $B->entry(1)],
                [$R->entry(2), $G->entry(2), $B->entry(2)],
                [$R->entry(3), $G->entry(3), $B->entry(3)],
            ]
        );

        $coloursI = $colours->inverse();

        $S = $coloursI->product($W);

        return new Matrix(
            [
                [$S->entry(1) * $R->entry(1), $S->entry(2) * $G->entry(1), $S->entry(3) * $B->entry(1)],
                [$S->entry(1) * $R->entry(2), $S->entry(2) * $G->entry(2), $S->entry(3) * $B->entry(2)],
                [$S->entry(1) * $R->entry(3), $S->entry(2) * $G->entry(3), $S->entry(3) * $B->entry(3)],
            ]
        );
    }

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

        $matrix = $this->inverseTransformationMatrix();

        $RGB = $matrix->product($XYZ);

        return [
            'R' => $this->compand($RGB->entry(1)),
            'G' => $this->compand($RGB->entry(2)),
            'B' => $this->compand($RGB->entry(3)),
        ];
    }

    /**
     * Returns the inverse of the transformation matrix for this colour space.
     *
     * @return Matrix
     */
    protected function inverseTransformationMatrix() {
        $matrix = $this->transformationMatrix();
        return $matrix->inverse();
    }

    /**
     * Compands linear RGB values into their "real" values within this colour
     * space.
     *
     * For most RGB colour spaces this will involve applying a gamma curve.
     *
     * @param float $input The value to be companded.
     *
     * @return float
     */
    abstract protected function compand($input);

    /**
     * @return string[]
     */
    protected function primaryKeys() {
        return ['R', 'G', 'B'];
    }

    /**
     * @var Colour the blue primary for this colour space.
     */
    protected $primaryBlue;

    /**
     * @var Colour the green primary for this colour space.
     */
    protected $primaryGreen;

    /**
     * @var Colour the red primary for this colour space.
     */
    protected $primaryRed;

    /**
     * @var Colour The white point for this colour space.
     */
    protected $referenceWhite;
}
