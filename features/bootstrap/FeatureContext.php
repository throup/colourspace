<?php

namespace Colourspace;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Colourspace\Colourspace\Usecase;
use PHPUnit_Framework_Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext {
    /**
     * @Given I have an sRGB colour defined as RGB(:red, :green, :blue)
     */
    public function iHaveAnSrgbColourDefinedAsRgb($red, $green, $blue) {
        $this->red   = $red;
        $this->green = $green;
        $this->blue  = $blue;
    }

    /**
     * @When I convert the colour to XYZ
     */
    public function iConvertTheColourToXyz() {
        $usecase = new Usecase\sRGB_to_XYZ();
        $this->response = $usecase->execute(
            [
                'R' => $this->red,
                'G' => $this->green,
                'B' => $this->blue,
            ]
        );
    }

    /**
     * @Then I should have the colour defined as XYZ(:X, :Y, :Z)
     */
    public function iShouldHaveTheColourDefinedAsXyz($X, $Y, $Z) {
        $expected = [
            'X' => $X,
            'Y' => $Y,
            'Z' => $Z,
        ];

        PHPUnit_Framework_Assert::assertEquals($expected, $this->response, '', 0.065);
    }

    /**
     * @var float
     */
    private $red   = 0.0;

    /**
     * @var float
     */
    private $green = 0.0;

    /**
     * @var float
     */
    private $blue  = 0.0;

    /**
     * @var array
     */
    private $response = [];
}
