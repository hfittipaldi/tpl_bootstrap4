<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Content Component Custom Query Helper
 *
 * @since  1.5
 */
class ContentHelperQueryCustom extends ContentHelperQuery
{
    /**
     * Method to revert the intro articles array order
     * for same ordering as the across.
     * The layout always lays the introtext articles out across columns.
     * The reordered is not necessary, once the layout is changed in the css.
     *
     * @param   array    &$articles   Array of intro text articles
     * @param   integer  $numColumns  Number of columns in the layout
     *
     * @return  array  Reordered array to achieve desired natural ordering
     */
    public static function revertArticlesOrder(&$articles, $numColumns = 1)
    {
        $count = count($articles);

        // Just return the same array if there is nothing to change
        if ($numColumns == 1 || !is_array($articles) || $count <= $numColumns)
        {
            return $articles;
        }

        // We need to preserve the original array keys
        $keys = array_keys($articles);
        $maxRows = (int) ceil($count / $numColumns);

        // Now read the $index back row by row to get articles in right row/col
        // so the order down of columns could be reverted
        $return = array();
        $i = 0;
        for ($col = 0; $col < $numColumns; $col++)
        {
            $a = $col;
            for ($row = 0; $row < $maxRows; $row++)
            {
                if ($i === $count) continue;

                $i++;
                $return[$i] = $articles[$keys[$a]];
                $a += $numColumns;
            }
        }

        return $return;
    }
}
