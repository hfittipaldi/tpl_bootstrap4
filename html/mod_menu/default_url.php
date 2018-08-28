<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$attributes = array();

$attributes['data-title'] = $item->title;

if ($item->anchor_title)
{
    $attributes['title'] = $item->anchor_title;
}

$attributes['class'] = 'nav-link';
if ($item->level > 1)
{
    $attributes['class'] = 'dropdown-item';
}

if ($item->level_diff == -1)
{
    $attributes['class']        .= ' dropdown-toggle';
    $attributes['data-toggle']   = 'dropdown';
    $attributes['role']          = 'button';
    $attributes['aria-haspopup'] = 'true';
    $attributes['aria-expanded'] = 'false';
}

if ($item->id === $active_id || ($item->type === 'alias' && $item->params->get('aliasoptions') === $active_id))
{
    $attributes['class'] .= ' active';
}

if ($item->anchor_css)
{
    $attributes['class'] .= ' ' . $item->anchor_css;
}

if ($item->anchor_rel)
{
    $attributes['rel'] = $item->anchor_rel;
}

$linktype = $item->title;

if ($item->menu_image)
{
    $linktype = JHtml::_('image', $item->menu_image, $item->title);
    if ($item->menu_image_css)
    {
        $image_attributes['class'] = $item->menu_image_css;
        $linktype = JHtml::_('image', $item->menu_image, $item->title, $image_attributes);
    }

    if ($item->params->get('menu_text', 1))
    {
        $linktype .= '<span class="image-title">' . $item->title . '</span>';
    }
}

if ($item->browserNav == 1)
{
    $attributes['target'] = '_blank';
    $attributes['rel'] = 'noopener noreferrer';

    if ($item->anchor_rel == 'nofollow')
    {
        $attributes['rel'] .= ' nofollow';
    }
}
elseif ($item->browserNav == 2)
{
    $options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,' . $params->get('window_open');

    $attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
}

echo JHtml::_('link', JFilterOutput::ampReplace(htmlspecialchars($item->flink, ENT_COMPAT, 'UTF-8', false)), $linktype, $attributes);
