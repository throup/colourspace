<?php
/**
 * This file contains the Space interface
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

/**
 * Interface Space
 */
interface Space {
    /**
     * @param float $p1
     * @param float $p2
     * @param float $p3
     * @return Colour
     */
    public function generate($p1, $p2, $p3);

    /**
     * @param Colour $colour
     * @return float[]
     */
    public function identify(Colour $colour);

    /**
     * @return Colour[]
     */
    public function primaries();

    /**
     * @return Colour
     */
    public function whitePoint();
}
