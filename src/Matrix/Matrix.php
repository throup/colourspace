<?php
/**
 * This file contains the Matrix class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace\Matrix;

use ArrayAccess;
use ArrayIterator;
use Colourspace\Exception;
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
        if ($row) {
            return count($row);
        } else {
            return 0;
        }
    }

    /**
     * Returns a new Matrix object resulting from the matrix multiplication of
     * this one with the second.
     *
     * @param self $second The matrix by which this will be multiplied.
     *
     * @return self
     * @throws Exception
     */
    public function product(self $second) {
        $rows = $second->rows();
        if ($this->columns() !== $rows) {
            throw new Exception();
        }

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
     * This is only defined for square matrices; attempting to use this method
     * on a non-square matrix will result in a thrown exception.
     *
     * @return self
     */
    public function inverse() {
        $this->throwExceptionIfNotSquare();

        $det = $this->determinant();
        $n   = $this->rows();

        $data = [];
        for ($i = 0; $i < $n; $i++) {
            $data[$i] = [];
            for ($j = 0; $j < $n; $j++) {
                $data[$i][$j] = $this->cofactor($j + 1, $i + 1) / $det;
            }
        }

        return new self($data);
    }

    /**
     * Returns the determinant of this matrix.
     *
     * This is only defined for square matrices; attempting to use this method
     * on a non-square matrix will result in a thrown exception.
     *
     * @return float
     */
    public function determinant() {
        $this->throwExceptionIfNotSquare();

        $n = $this->rows();
        if ($n === 1) {
            return $this[0][0];
        } else {
            $det = 0;
            for ($i = 0; $i < $n; $i++) {
                $det += $this[0][$i] * $this->cofactor(1, $i + 1);
            }
            return $det;
        }
    }

    /**
     * Calculated the cofactor for the given row and column.
     *
     * The cofactor is defined as the determinant of the submatrix resulting
     * from the removal of the given row and column.
     *
     * @param int $row    The row for which the cofactor will be calculated.
     * @param int $column The column for which the cofactor will be calculated.
     *
     * @return float
     * @todo Explicit unit tests as this is a public method.
     */
    public function cofactor($row, $column) {
        $submatrix = $this->submatrix($row, $column);
        $sign = (($row + $column) % 2) ? -1 : 1;
        return $sign * $submatrix->determinant();
    }

    /**
     * Returns a submatrix, generated by removing the given row and column
     * from this matrix.
     *
     * @param int $row    The row to remove.
     * @param int $column The column to remove.
     *
     * @return self
     */
    public function submatrix($row, $column) {
        $data = [];
        foreach ($this as $i => $arow) {
            if ($i !== $row - 1) {
                unset($arow[$column - 1]);
                $data[] = array_values($arow);
            }
        }
        return new self($data);
    }

    /**
     * Utility method for operations which are only defined upon square
     * matrices.
     *
     * @throws Exception
     */
    protected function throwExceptionIfNotSquare() {
        if (!$this->isSquare()) {
            throw new Exception();
        }
    }

    /**
     * Returns the entry found at the intersection of the given row and column.
     *
     * @param int $row The row in which the entry is found.
     * @param int $col The column in which the entry is found.
     *
     * @return float
     */
    public function entry($row, $col) {
        return $this[$row - 1][$col - 1];
    }
}
