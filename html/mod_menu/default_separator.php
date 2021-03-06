<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$title = $item->title;
if ($item->anchor_title)
{
    $title = $item->anchor_title;
}

$attribs = ' data-title="' . $title . '"';

$anchor_css = '';
if ($item->anchor_css)
{
    $anchor_css .= $item->anchor_css . ' ';
}
$anchor_css .= 'nav-link';

if ($item->level_diff == -1)
{
    $anchor_css .= ' dropdown-toggle';
    $attribs    .= ' data-toggle="dropdown"';
    $attribs    .= ' role="button"';
    $attribs    .= ' aria-haspopup="true"';
    $attribs    .= ' aria-expanded="false"';
}

$linktype = $item->title;

if ($item->menu_image)
{
    if ($item->menu_image_css)
    {
        $image_attributes['class'] = $item->menu_image_css;
        $linktype = JHtml::_('image', $item->menu_image, $item->title, $image_attributes);
    }
    else
    {
        $linktype = JHtml::_('image', $item->menu_image, $item->title);
    }

    if ($item->params->get('menu_text', 1))
    {
        $linktype .= '<span class="image-title">' . $item->title . '</span>';
    }
}

?>
<span class="separator <?php echo $anchor_css; ?>"<?php echo $attribs; ?>><?php echo $linktype; ?></span>
