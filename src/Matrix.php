<?php
/**
 * This file contains the Matrix class.
 *
 * @author    Chris Throup <chris@throup.org.uk>
 * @copyright 2014 Chris Throup
 * @licence   GPL-3.0+
 */

namespace Colourspace;

use ArrayIterator;

/**
 * Class Matrix
 */
class Matrix extends ArrayIterator {
    /**
     * @param self $second
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
     * @param $row
     * @param $row2
     *
     * @return array
     */
    protected function addRows($row, $row2) {
        $newrow = [];
        foreach ($row as $colid => $col) {
            $newrow[$colid] = $col + $row2[$colid];
        }
        return $newrow;
    }}
