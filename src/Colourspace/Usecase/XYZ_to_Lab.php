<?php
/**
 * This file contains the XYZ to Lab use case.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace\Usecase;

use Colourspace\Colourspace\Space;
use Colourspace\Colourspace\Usecase;

/**
 * Convert a colour from XYZ to Lab colour spaces.
 */
class XYZ_to_Lab implements Usecase {
    public function __construct() {
        $this->Lab = new Space\Lab();
        $this->XYZ = new Space\XYZ();
    }

    /**
     * @param array|float[] $input {
     *     @var float $X
     *     @var float $Y
     *     @var float $Z
     * }
     *
     * @return array|float[] {
     *     @var float $L
     *     @var float $a
     *     @var float $b
     * }
     */
    public function execute($input) {
        $colour = $this->XYZ->generate(
            $input['X'] / 100,
            $input['Y'] / 100,
            $input['Z'] / 100
        );

        return $this->Lab->identify($colour);
    }

    /**
     * @var Space\Lab
     */
    private $Lab;

    /**
     * @var Space\XYZ
     */
    private $XYZ;
}
