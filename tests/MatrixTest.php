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

    /**
     * @test
     */
    public function inverseOf2x2IdentityMatrix_returnsEqualMatrix() {
        $identity = new Matrix(
            [
                [1, 0],
                [0, 1],
            ]
        );

        $result = $identity->inverse();

        $this->assertEquals($identity, $result);
    }

    /**
     * @test
     */
    public function inverseOf2x2Matrix_returnsExpectedValue() {
        $matrix = new Matrix(
            [
                [1, 2],
                [3, 4],
            ]
        );

        $expected = new Matrix(
            [
                [-2.0,  1.0],
                [ 1.5, -0.5],
            ]
        );

        $result = $matrix->inverse();

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function inverseOf2x2Matrix_asProductWithselfGivesIdentity() {
        $matrix = new Matrix(
            [
                [1, 2],
                [3, 4],
            ]
        );

        $inverse = $matrix->inverse();

        $identity = new Matrix(
            [
                [1, 0],
                [0, 1],
            ]
        );

        $this->assertEquals($identity, $matrix->product($inverse));
        $this->assertEquals($identity, $inverse->product($matrix));
    }

    /**
     * @test
     */
    public function inverseOf3x3IdentityMatrix_returnsEqualMatrix() {
        $identity = new Matrix(
            [
                [1, 0, 0],
                [0, 1, 0],
                [0, 0, 1],
            ]
        );

        $result = $identity->inverse();

        $this->assertEquals($identity, $result);
    }

    /**
     * @test
     */
    public function inverseOf3x3Matrix_returnsExpectedValue() {
        $matrix = new Matrix(
            [
                [1, 0, 2],
                [0, 3, 0],
                [4, 0, 5],
            ]
        );

        $expected = new Matrix(
            [
                [-15/9,  0,   6/9],
                [  0,    3/9, 0  ],
                [ 12/9,  0,  -3/9],
            ]
        );

        $result = $matrix->inverse();

        $this->assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function inverseOf3x3Matrix_asProductWithselfGivesIdentity() {
        $matrix = new Matrix(
            [
                [1, 0, 2],
                [0, 3, 0],
                [4, 0, 5],
            ]
        );

        $inverse = $matrix->inverse();

        $identity = new Matrix(
            [
                [1, 0, 0],
                [0, 1, 0],
                [0, 0, 1],
            ]
        );

        $this->assertEquals($identity, $matrix->product($inverse));
        $this->assertEquals($identity, $inverse->product($matrix));
    }

    /**
     * @test
     */
    public function determinantOf1x1IdentityMatrix_returnsExpectedValue() {
        $matrix = new Matrix(
            [
                [1],
            ]
        );

        $expected = 1;

        $this->assertEquals($expected, $matrix->determinant());
    }

    /**
     * @test
     */
    public function determinantOfPositive1x1Matrix_returnsExpectedValue() {
        $matrix = new Matrix(
            [
                [4],
            ]
        );

        $expected = 4;

        $this->assertEquals($expected, $matrix->determinant());
    }

    /**
     * @test
     */
    public function determinantOfNegative1x1Matrix_returnsExpectedValue() {
        $matrix = new Matrix(
            [
                [-7],
            ]
        );

        $expected = -7;

        $this->assertEquals($expected, $matrix->determinant());
    }

    /**
     * @test
     */
    public function determinantOf2x2IdentityMatrix_returnsExpectedValue() {
        $matrix = new Matrix(
            [
                [1, 0],
                [0, 1],
            ]
        );

        $expected = 1;

        $this->assertEquals($expected, $matrix->determinant());
    }

    /**
     * @test
     */
    public function determinantOfPositive2x2Matrix_returnsExpectedValue() {
        $matrix = new Matrix(
            [
                [ 1,  2],
                [-2, -1],
            ]
        );

        $expected = 3;

        $this->assertEquals($expected, $matrix->determinant());
    }

    /**
     * @test
     */
    public function determinantOfNegative2x2Matrix_returnsExpectedValue() {
        $matrix = new Matrix(
            [
                [1, 2],
                [3, 4],
            ]
        );

        $expected = -2;

        $this->assertEquals($expected, $matrix->determinant());
    }

    /**
     * @test
     */
    public function determinantOf3x3IdentityMatrix_returnsExpectedValue() {
        $matrix = new Matrix(
            [
                [1, 0, 0],
                [0, 1, 0],
                [0, 0, 1],
            ]
        );

        $expected = 1;

        $this->assertEquals($expected, $matrix->determinant());
    }

    /**
     * @test
     */
    public function determinantOfPositive3x3Matrix_returnsExpectedValue() {
        $matrix = new Matrix(
            [
                [-2,  2, -3],
                [-1,  1,  3],
                [ 2,  0, -1]
            ]
        );

        $expected = 18;

        $this->assertEquals($expected, $matrix->determinant());
    }

    /**
     * @test
     */
    public function determinantOfNegative3x3Matrix_returnsExpectedValue() {
        $matrix = new Matrix(
            [
                [1, 0, 2],
                [0, 3, 0],
                [4, 0, 5],
            ]
        );

        $expected = -9;

        $this->assertEquals($expected, $matrix->determinant());
    }

    /**
     * @test
     * @expectedException \Colourspace\Exception
     */
    public function determinantOfNonSquareMatrix_throwsException() {
        $matrix = $this->exampleNonSquareMatrix();
        $matrix->determinant();
    }

    /**
     * @test
     * @expectedException \Colourspace\Exception
     */
    public function inverseOfNonSquareMatrix_throwsException() {
        $matrix = $this->exampleNonSquareMatrix();
        $matrix->inverse();
    }

    /**
     * @test
     */
    public function isSquare_returnsTrueForSquareMatrix() {
        $matrix = $this->exampleSquareMatrix();
        $this->assertTrue($matrix->isSquare());
    }

    /**
     * @test
     */
    public function isSquare_returnsFalseForNonSquareMatrix() {
        $matrix = $this->exampleNonSquareMatrix();
        $this->assertFalse($matrix->isSquare());
    }

    /**
     * @return Matrix
     */
    protected function exampleNonSquareMatrix() {
        return new Matrix(
            [
                [1, 2, 3],
                [4, 5, 6],
            ]
        );
    }

    /**
     * @return Matrix
     */
    protected function exampleSquareMatrix() {
        return new Matrix(
            [
                [1, 2],
                [3, 4],
            ]
        );
    }
}

