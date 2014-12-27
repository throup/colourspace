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
        switch ($this->rows()) {
            case 2:
                return $this->invert2();

            case 3:
                return $this->invert3();
        }

        $data = [];

        return new self($data);
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
        if ($this->rows() === 1 && $this->columns() === 1) {
            return abs($this[0][0]);
        } else if ($this->rows() === 2 && $this->columns() === 2) {
            return $this[0][0] * $this[1][1] - $this[0][1] * $this[1][0];
        } else {
            return $this[0][0] * $this[1][1] * $this[2][2]
                 + $this[0][1] * $this[1][2] * $this[2][0]
                 + $this[0][2] * $this[1][0] * $this[2][1]
                 - $this[0][2] * $this[1][1] * $this[2][0]
                 - $this[0][0] * $this[1][2] * $this[2][1]
                 - $this[0][1] * $this[1][0] * $this[2][2];
        }
    }

    /**
     * Return the inverse of this matrix.
     *
     * This is an internal utility method which should only be user if the
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
     * This is an internal utility method which should only be user if the
     * matrix has been confirmed to be an invertible 3x3.
     *
     * @return self
     */
    protected function invert3() {
        $det = $this->determinant();

        $a = $this[0][0];
        $b = $this[0][1];
        $c = $this[0][2];
        $d = $this[1][0];
        $e = $this[1][1];
        $f = $this[1][2];
        $g = $this[2][0];
        $h = $this[2][1];
        $i = $this[2][2];

        $A = $e * $i - $f * $h;
        $B = $f * $g - $d * $i;
        $C = $d * $h - $e * $g;
        $D = $c * $h - $b * $i;
        $E = $a * $i - $c * $g;
        $F = $b * $g - $a * $h;
        $G = $b * $f - $c * $e;
        $H = $c * $d - $e * $f;
        $I = $a * $e - $b * $d;

        $data = [
            [$A / $det, $D / $det, $G / $det],
            [$B / $det, $E / $det, $H / $det],
            [$C / $det, $F / $det, $I / $det],
        ];

        return new self($data);
    }
}
