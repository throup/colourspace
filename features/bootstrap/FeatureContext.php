<?php

namespace Colourspace;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Colourspace\Colourspace\Colour;
use Colourspace\Colourspace\Space;
use PHPUnit_Framework_Assert;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
    public function __construct()
    {
    }

    /**
     * @Given I have an sRGB colour defined as RGB(:red, :green, :blue)
     */
    public function iHaveAnSrgbColourDefinedAsRgb($red, $green, $blue)
    {
        $colourspace = new Space\sRGB();
        $this->colour = $colourspace->generate($red / 255, $green / 255, $blue / 255);
    }

    /**
     * @When I convert the colour to XYZ
     */
    public function iConvertTheColourToXyz()
    {
        // Do nothing here.
    }

    /**
     * @Then I should have the colour defined as XYZ(:X, :Y, :Z)
     */
    public function iShouldHaveTheColourDefinedAsXyz($X, $Y, $Z)
    {
        $expected = [
            'X' => $X,
            'Y' => $Y,
            'Z' => $Z,
        ];

        $actual = [
            'X' => $this->colour->getX() * 100,
            'Y' => $this->colour->getY() * 100,
            'Z' => $this->colour->getZ() * 100,
        ];

        PHPUnit_Framework_Assert::assertEquals($expected, $actual, '', 0.065);
    }

    /**
     * @var Colour
     */
    private $colour;
}
