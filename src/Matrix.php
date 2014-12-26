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
}
