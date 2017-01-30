# Colourspace

Library to aid the manipulation of colours within different colour spaces

## Examples

### Generate an object representing an sRGB colour

```
$space  = new \Colourspace\Colourspace\Space\sRGB();
$red    = $space->generate(1, 0, 0);
$green  = $space->generate(0, 1, 0);
$blue   = $space->generate(0, 0, 1);
$black  = $space->generate(0, 0, 0);
$white  = $space->generate(1, 1, 1);

$white == $space->whitePoint();
```

For other examples, see the test suites.


## Setting up a development and testing environment

The repository contains a `composer.json` file to aid the installation of the necessary development tools.

To set up a development environment, follow these steps:

```
#!sh
$ git clone https://github.com/throup/colourspace.git
$ cd colourspace
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```

## Running the tests

### Unit tests

There is a PHPUnit configuration file at `config/phpunit.xml`. To run the complete test suite, execute:

```
#!sh
$ vendor/bin/phpunit -c config/phpunit.xml
```

### Acceptance tests

The acceptance test suite uses Behat to validate the library feature-set (contained in `features/`). To run the complete test suite, execute:

```
#!sh
$ vendor/bin/behat --config config/behat.yml 
```

### Using Phing

There is a Phing build script at `build.xml` which defines targets for all of the test suites as well as code quality metrics and documentation tools.

```
#!sh
$ phing                    # executes all test suites, metrics and documentation

$ phing phpunit            # executes only the unit test suite

$ phing behat              # executes only the acceptance test suite

$ phing phpdox             # generate HTML documentation for the library

$ phing phpmetrics         # generate a code quality report
```