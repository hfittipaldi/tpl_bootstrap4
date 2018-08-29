<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

$selector   = $displayData['selector'] ?? '';
$id         = $displayData['id'] ?? '';
$active     = $displayData['active'] ?? '';
$title      = $displayData['title'] ?? '';
$selected   = $active ? 'true' : 'false';

$li = '<li class="nav-item" role="presentation"><a class="nav-link' . $active . '" href="#' . $id . '" data-toggle="tab" role="tab" aria-controls="' . $id . '" aria-selected="' . $selected . '">' . $title . '</a></li>';

echo 'jQuery(function($){ $(', json_encode('#' . $selector . 'Tabs'), ').append($(', json_encode($li), ')); });';
