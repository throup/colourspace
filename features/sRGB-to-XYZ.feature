Feature: Converting sRGB colours to XYZ
In order to work with sRGB colours in my application
As a developer
I need to be able to convert sRGB colours to the XYZ colour space.

  Scenario Outline: Converting colours
    Given I have an sRGB colour defined as RGB(<red>, <green>, <blue>)
     When I convert the colour to XYZ
     Then I should have the colour defined as XYZ(<X>, <Y>, <Z>)

    Examples:
      | red | green | blue | X       | Y        | Z        |
      | 255 |     0 |    0 | 41.2456 |  21.2673 |   1.9334 |
      |   0 |   255 |    0 | 35.7576 |  71.5152 |  11.9192 |
      |   0 |     0 |  255 | 18.0437 |   7.2175 |  95.0304 |
      |   0 |     0 |    0 |  0.0000 |   0.0000 |   0.0000 |
      | 255 |   255 |  255 | 95.0470 | 100.0000 | 108.8830 |
