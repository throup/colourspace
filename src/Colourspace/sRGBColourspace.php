<?php
/**
 * This file contains the sRGBColourspace class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014-2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;
use Colourspace\Matrix\Matrix;

/**
 * Represents the sRGB colourspace.
 */
class sRGBColourspace {
    /**
     * @return Colour
     */
    public function whitePoint() {
        $factory = new StandardIlluminantFactory();
        return $factory->D(65);
    }

    /**
     * @return Colour[]
     */
    public function primaries() {
        $colourspace = new xyYColourspace();
        return [
            'R' => $colourspace->generate(0.6400, 0.3300, 0.212656),
            'G' => $colourspace->generate(0.3000, 0.6000, 0.715158),
            'B' => $colourspace->generate(0.1500, 0.0600, 0.072186),
        ];
    }

    /**
     * @param Colour $colour
     * @return float[]
     */
    public function identify(Colour $colour) {
        return [
            'R' => $colour->getRed(),
            'G' => $colour->getGreen(),
            'B' => $colour->getBlue(),
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

        return new XyzColour($X, $Y, $Z);
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
        $primaries = $this->primaries();
        $colour = $primaries['R'];
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
        $primaries = $this->primaries();
        $colour = $primaries['G'];
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
        $primaries = $this->primaries();
        $colour = $primaries['B'];
        return new Matrix(
            [
                [$colour->getX()],
                [$colour->getY()],
                [$colour->getZ()],
            ]
        );
    }
}
