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
        $this->input = [
            'R' => $red,
            'G' => $green,
            'B' => $blue,
        ];
    }

    /**
     * @Given I have an XYZ colour defined as XYZ(:X, :Y, :Z)
     */
    public function iHaveAnXyzColourDefinedAsXyz($X, $Y, $Z) {
        $this->input = [
            'X' => $X,
            'Y' => $Y,
            'Z' => $Z,
        ];
    }

    /**
     * @Given I am using standard illuminant: D65
     */
    public function iAmUsingStandardIlluminantD65() {
        // Do nothing.
    }

    /**
     * @When I convert the colour to XYZ
     */
    public function iConvertTheColourToXyz() {
        $this->usecase = new Usecase\sRGB_to_XYZ();
    }

    /**
     * @When I convert the colour to sRGB
     */
    public function iConvertTheColourToSrgb() {
        $this->usecase = new Usecase\XYZ_to_sRGB();
    }

    /**
     * @When I convert the colour to Lab
     */
    public function iConvertTheColourToLab() {
        $this->usecase = new Usecase\XYZ_to_Lab();
    }

    /**
     * @Then /^I should have the colour defined as (\w)(\w)(\w)\(([\d\.\-]+),\s*([\d\.\-]+),\s*([\d\.\-]+)\)$/
     */
    public function iShouldHaveTheColourDefinedAs($k1, $k2, $k3, $v1, $v2, $v3) {
        $expected = [
            $k1 => $v1,
            $k2 => $v2,
            $k3 => $v3,
        ];

        $this->validateResponse($expected, 0.08);
    }

    /**
     * @param $expected
     * @param $delta
     */
    protected function validateResponse($expected, $delta) {
        $actual = $this->usecase->execute($this->input);
        PHPUnit_Framework_Assert::assertEquals($expected,
                                               $actual,
                                               var_export($actual, true),
                                               $delta);
    }

    /**
     * @var Usecase
     */
    private $usecase;
}
