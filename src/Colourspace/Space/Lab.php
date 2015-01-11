<?php
/**
 * This file contains the Lab class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Space;

use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;
use Colourspace\Colourspace\StandardIlluminantFactory;


/**
 * Represents the Lab colourspace.
 */
class Lab extends XYZbased {
    public function __construct() {
        $factory = new StandardIlluminantFactory();

        $this->referenceWhite = $factory->D(65);
    }

    /**
     * @param Colour $colour
     * @return float[]
     */
    public function identify(Colour $colour) {
        return [];
    }

    /**
     * @return string[]
     */
    protected function primaryKeys() {
        return [
            'L',
            'a',
            'b',
        ];
    }
}
