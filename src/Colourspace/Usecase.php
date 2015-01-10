<?php
/**
 * This file contains the Usecase interface.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2015 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Colourspace;

/**
 * Interface Usecase
 */
interface Usecase {
    /**
     * @param array $input
     *
     * @return array
     */
    public function execute($input);
}
