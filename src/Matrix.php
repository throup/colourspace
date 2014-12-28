<?php
/**
 * This file contains the Matrix class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace;

use ArrayAccess;
use ArrayIterator;
use Traversable;

/**
 * Class Matrix
 */
class Matrix extends ArrayIterator {
    /**
     * Returns a new Matrix object resulting from the addition of this one
     * with the second.
     *
     * @param self $second The matrix to be added.
     *
     * @return self
     */
    public function add(self $second) {
        $new = [];
        foreach ($this as $rowid => $row) {
            $new[$rowid] = $this->addRows($row, $second[$rowid]);
        }
        return new self($new);
    }

    /**
     * Utility method to return the sum of two matrix rows.
     *
     * @param Traversable|float[] $row  The first row.
     * @param ArrayAccess|float[] $row2 The second row.
     *
     * @return float[]
     */
    protected function addRows($row, $row2) {
        $newrow = [];
        foreach ($row as $colid => $col) {
            $newrow[$colid] = $col + $row2[$colid];
        }
        return $newrow;
    }

    /**
     * Is this a square matrix? That is, does it have an equal number of rows
     * and columns?
     *
     * @return bool
     */
    public function isSquare() {
        return $this->rows() === $this->columns();
    }

    /**
     * The number of rows within this matrix.
     *
     * @return int
     */
    public function rows() {
        return count($this);
    }

    /**
     * The number of columns within this matrix.
     *
     * @return int
     */
    public function columns() {
        $row = reset($this);
        return count($row);
    }

    /**
     * Returns a new Matrix object resulting from the matrix multiplication of
     * this one with the second.
     *
     * @param self $second The matrix by which this will be multiplied.
     *
     * @return self
     */
    public function product(self $second) {
        $rows = $second->rows();
        $cols = $second->columns();
        $data = [];
        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                $data[$i][$j] = 0;
                for ($k = 0; $k < $rows; $k++) {
                    $data[$i][$j] += $this[$i][$k] * $second[$k][$j];
                }
            }
        }
        return new self($data);
    }

    /**
     * Return the inverse of this matrix.
     *
     * Currently only works for 2-square matrices _with no checks for error
     * conditions_. This may ultimately need to defer to separate classes for
     * a complete solution.
     *
     * @return self
     * @todo Implement a universal algorithm.
     */
    public function inverse() {
        if ($this->rows() === 2) {
            return $this->invert2();
        } else {
            return $this->invert3();
        }
    }

    /**
     * Returns the determinant of this matrix.
     *
     * Currently only works for square matrices <= 3x3 _with no checks for
     * error conditions_. This may ultimately need to defer to separate classes
     * for a complete solution.
     *
     * @return float
     * @todo Implement a universal algorithm.
     */
    public function determinant() {
        if (!$this->isSquare()) {
            throw new Exception();
        }

        $n = $this->rows();
        if ($n === 1) {
            return abs($this[0][0]);
        } else if ($n === 2) {
            return $this[0][0] * $this[1][1] - $this[0][1] * $this[1][0];
        } else {
            $det = 0;
            for ($i = 0; $i < $n; $i++) {
                $sign = ($i % 2) ? -1 : 1;
                $det += $sign * $this[0][$i] * $this->cofactor(0, $i);
            }
            return $det;
        }
    }

    /**
     * Return the inverse of this matrix.
     *
     * This is an internal utility method which should only be used if the
     * matrix has been confirmed to be an invertible 2x2.
     *
     * @return self
     */
    protected function invert2() {
        $data = [];
        $det = $this->determinant();

        $data[] = [$this[1][1] / $det, 0 - $this[0][1] / $det];
        $data[] = [0 - $this[1][0] / $det, $this[0][0] / $det];
        return new self($data);
    }

    /**
     * Return the inverse of this matrix.
     *
     * This is an internal utility method which should only be used if the
     * matrix has been confirmed to be an invertible 3x3.
     *
     * @return self
     */
    protected function invert3() {
        $det = $this->determinant();

        $A = $this->cofactor(0, 0);
        $B = $this->cofactor(0, 1);
        $C = $this->cofactor(0, 2);
        $D = $this->cofactor(1, 0);
        $E = $this->cofactor(1, 1);
        $F = $this->cofactor(1, 2);
        $G = $this->cofactor(2, 0);
        $H = $this->cofactor(2, 1);
        $I = $this->cofactor(2, 2);

        $data = [
            [$A / $det, $D / $det, $G / $det],
            [$B / $det, $E / $det, $H / $det],
            [$C / $det, $F / $det, $I / $det],
        ];

        return new self($data);
    }

    /**
     * @param int $row
     * @param int $column
     * @return float
     * @todo Explicit unit tests as this is a public method.
     */
    public function cofactor($row, $column) {
        $submatrix = $this->submatrix($row, $column);
        return $submatrix->determinant();
    }

    /**
     * @param int $row
     * @param int $column
     * @return self
     * @todo Explicit unit tests as this is a public method.
     */
    public function submatrix($row, $column) {
        $data = [];
        foreach($this as $i => $arow) {
            if ($i !== $row) {
                unset($arow[$column]);
                $data[] = array_values($arow);
            }
        }
        return new self($data);
    }
}
