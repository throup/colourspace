<?php

namespace colourspace;

/**
 * Class RgbColour
 *
 * @package colourspace
 */
class RgbColour {
    /**
     * @param float $red
     * @param float $green
     * @param float $blue
     */
    public function __construct($red = 0.0, $green = 0.0, $blue = 0.0) {
        $this->red   = (float) $red;
        $this->green = (float) $green;
        $this->blue  = (float) $blue;
    }

    /**
     * @return float
     */
    public function getRed() {
        return (float) $this->red;
    }

    /**
     * @return float
     */
    public function getGreen() {
        return (float) $this->green;
    }

    /**
     * @return float
     */
    public function getBlue() {
        return (float) $this->blue;
    }

    /**
     * @param  self $second
     *
     * @return bool
     */
    public function equals(self $second) {
        return ($this->getRed()   == $second->getRed())
            && ($this->getGreen() == $second->getGreen())
            && ($this->getBlue()  == $second->getBlue());
    }

    /**
     * @type float
     */
    private $red   = 0.0;

    /**
     * @type float
     */
    private $green = 0.0;

    /**
     * @type float
     */
    private $blue  = 0.0;
}
