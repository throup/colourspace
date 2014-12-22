<?php
/**
 * This file contains test cases for the Matrix class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace;

use PHPUnit_Framework_TestCase;

/**
 * Class MatrixTest
 */
class MatrixTest extends PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function canIterateOverValues() {
        $array  = [ [1] ];
        $matrix = new Matrix($array);

        $count = 0;
        foreach ($matrix as $item) {
            $count++;
        }
        $this->assertEquals(1, $count);
    }

    /**
     * @test
     */
    public function whenIterating_valuesMatchThoseFromConstructor() {
        $value  = 1;
        $array  = [ [$value] ];
        $matrix = new Matrix($array);

        foreach ($matrix as $item) {
            $this->assertEquals([$value], $item);
        }
    }

    /**
     * @test
     */
    public function additionWorks() {
        $first = new Matrix(
            [
                [ 1,  2],
                [ 3,  4],
            ]
        );

        $second = new Matrix(
            [
                [ 5,  6],
                [ 7,  8],
            ]
        );

        $expected = new Matrix(
            [
                [ 6,  8],
                [10, 12],
            ]
        );

        $this->assertEquals($expected, $first->add($second));
        $this->assertEquals($expected, $second->add($first));
    }
}
