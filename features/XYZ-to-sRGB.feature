Feature: Converting XYZ colours to sRGB
In order to work with sRGB colours in my application
As a developer
I need to be able to convert XYZ colours to the sRGB colour space.

  Scenario Outline: Converting colours
    Given I have an XYZ colour defined as XYZ(<X>, <Y>, <Z>)
     When I convert the colour to sRGB
     Then I should have the colour defined as RGB(<red>, <green>, <blue>)

    Examples:
      | X       | Y        | Z        | red | green | blue |
      | 41.2456 |  21.2673 |   1.9334 | 255 |     0 |    0 |
      | 35.7576 |  71.5152 |  11.9192 |   0 |   255 |    0 |
      | 18.0437 |   7.2175 |  95.0304 |   0 |     0 |  255 |
      |  0.0000 |   0.0000 |   0.0000 |   0 |     0 |    0 |
      | 95.0470 | 100.0000 | 108.8830 | 255 |   255 |  255 |
