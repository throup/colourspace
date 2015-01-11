Feature: Converting XYZ colours to Lab
In order to work with Lab colours in my application
As a developer
I need to be able to convert XYZ colours to the Lab colour space.

  Scenario Outline: Converting colours
    Given I have an XYZ colour defined as XYZ(<X>, <Y>, <Z>)
      And I am using standard illuminant: D65
     When I convert the colour to Lab
     Then I should have the colour defined as Lab(<L*>, <a*>, <b*>)

    Examples:
      |  X       | Y        | Z        | L*      | a*      | b*       |
      |  95.0470 | 100.0000 | 108.8830 | 100.000 |   0.000 |    0.000 |
      |  17.5060 |  18.4190 |  20.0550 |  50.000 |   0.000 |    0.000 |
      |  78.4240 |   0.0000 |   0.0000 |   0.000 | 400.000 |    0.000 |
      |  17.5060 |  18.4190 |   0.0140 |  50.000 |   0.000 |   86.000 |
      |  41.2400 |  21.2600 |   1.9300 |  53.233 |  80.109 |   67.220 |
      |  35.7600 |  71.5200 |  11.9200 |  87.737 | -86.185 |   83.181 |
      |  18.0500 |   7.2200 |  95.0500 |  32.303 |  79.197 | -107.864 |
      |   0      |   0      |   0      |   0     |   0     |    0     |
