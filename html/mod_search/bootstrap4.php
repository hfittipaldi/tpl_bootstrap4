<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_search
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Including fallback code for the placeholder attribute in the search field.
JHtml::_('jquery.framework');

$size = '';
if ($width)
{
    $moduleclass_sfx .= ' ' . 'mod_search' . $module->id;
    $css = 'div.mod_search' . $module->id . ' input[type="search"]{ width:auto; }';
    JFactory::getDocument()->addStyleDeclaration($css);
    $size = ' size="' . $width . '"';
}
?>
<div class="search<?php echo $moduleclass_sfx; ?>">
    <form action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-inline">
        <?php
        $output = '<input name="searchword" id="mod-search-searchword-' . $module->id . '" maxlength="' . $maxlength . '"  class="form-control search-query" type="search"' . $size . ' aria-label="' . $label . '" aria-describedby="searchword-' . $module->id . '" placeholder="' . $text . '" />';

        if ($button)
        {
            if (strpos($button_text, 'icon-') !== false)
            {
                $button_text = '<span class="' . $button_text . '"></span>';
            }

            $btn_output = '    <button class="input-group-text" id="searchword-' . $module->id . '">' . $button_text . '</button>';
            if ($imagebutton)
            {
                $btn_output = ' <input type="image" alt="' . $button_text . '" id="searchword-' . $module->id . '" class="button input-group-text" src="' . $img . '" onclick="this.form.searchword.focus();"/>';
            }

            switch ($button_pos)
            {
                case 'bottom' :
                case 'right' :
                    $output = '<div class="input-group">' . $output . '<div class="input-group-append">' . $btn_output . '</div></div>';
                    break;

                case 'top' :
                case 'left' :
                default :
                    $output = '<div class="input-group"><div class="input-group-prepend">' . $btn_output . '</div>' . $output . '</div>';
                    break;
            }
        }

        echo $output;
        ?>

        <input type="hidden" name="task" value="search" />
        <input type="hidden" name="option" value="com_search" />
        <input type="hidden" name="Itemid" value="<?php echo $mitemid; ?>" />
    </form>
</div>
