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

    /**
     * @test
     */
    public function rows_returnsCorrectValue() {
        $matrix = new Matrix(
            [
                [ 1,  2,  3],
                [ 4,  5,  6],
            ]
        );

        $this->assertEquals(2, $matrix->rows());
    }

    /**
     * @test
     */
    public function columns_returnsCorrectValue() {
        $matrix = new Matrix(
            [
                [ 1,  2,  3],
                [ 4,  5,  6],
            ]
        );

        $this->assertEquals(3, $matrix->columns());
    }

    /**
     * @test
     */
    public function productOfTwoEmptyMatrices_returnsCorrectValue() {
        $first = new Matrix(
            []
        );
        $second = new Matrix(
            []
        );
        $expected = new Matrix(
            []
        );

        $result = $first->product($second);

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function productOfTwo1x1Matrices_returnsCorrectValue() {
        $first = new Matrix(
            [
                [2],
            ]
        );
        $second = new Matrix(
            [
                [3],
            ]
        );
        $expected = new Matrix(
            [
                [6],
            ]
        );

        $result = $first->product($second);

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function productOfTwo1x1IdentityMatrices_returnsCorrectValue() {
        $first = new Matrix(
            [
                [1],
            ]
        );
        $second = new Matrix(
            [
                [1],
            ]
        );
        $expected = new Matrix(
            [
                [1],
            ]
        );

        $result = $first->product($second);

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function productOfTwo2x2IdentityMatrices_returnsCorrectValue() {
        $first = new Matrix(
            [
                [1, 0],
                [0, 1],
            ]
        );
        $second = new Matrix(
            [
                [1, 0],
                [0, 1],
            ]
        );
        $expected = new Matrix(
            [
                [1, 0],
                [0, 1],
            ]
        );

        $result = $first->product($second);

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function productOfTwo2x2Matrices_returnsCorrectValue() {
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
                [19, 22],
                [43, 50],
            ]
        );

        $result = $first->product($second);

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function productOfTwo3x3Matrices_returnsCorrectValue() {
        $first = new Matrix(
            [
                [ 1,  2,  3],
                [ 4,  5,  6],
                [ 7,  8,  9],
            ]
        );
        $second = new Matrix(
            [
                [10, 11, 12],
                [13, 14, 15],
                [16, 17, 18],
            ]
        );
        $expected = new Matrix(
            [
                [ 84,  90,  96],
                [201, 216, 231],
                [318, 342, 366],
            ]
        );

        $result = $first->product($second);

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function productOfVectorAnd3x3Matrix_returnsCorrectValue() {
        $matrix = new Matrix(
            [
                [ 1,  2,  3],
                [ 4,  5,  6],
                [ 7,  8,  9],
            ]
        );
        $vector = new Matrix(
            [
                [ 1],
                [ 2],
                [ 3],
            ]
        );
        $expected = new Matrix(
            [
                [14],
                [32],
                [50],
            ]
        );

        $result = $matrix->product($vector);

        $this->assertEquals($expected, $result);
    }
}
