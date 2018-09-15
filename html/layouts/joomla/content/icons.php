<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JHtml::_('bootstrap.framework');

$params    = $displayData['params'];
$canEdit   = $params->get('access-edit');
$article   = $displayData['item'];
$articleId = $article->id;
$attribs['class'] = 'dropdown-item hasTooltip';
?>

<div class="icons">
    <?php if (empty($displayData['print'])) : ?>

        <?php if ($canEdit || $params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
    <div class="btn-group float-right">
        <button class="btn btn-sm dropdown-toggle" type="button" id="dropdownMenuButton-<?php echo $articleId; ?>" aria-label="<?php echo JText::_('JUSER_TOOLS'); ?>"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="icon-cog" aria-hidden="true"></span>
        </button>
        <?php // Note the actions class is deprecated. Use dropdown-menu instead. ?>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton-<?php echo $articleId; ?>">
            <?php if ($params->get('show_print_icon')) : ?>
                <li class="print-icon"> <?php echo JHtml::_('icon.print_popup', $article, $params, $attribs); ?> </li>
            <?php endif; ?>
            <?php if ($params->get('show_email_icon')) : ?>
                <li class="email-icon"> <?php echo JHtml::_('icon.email', $article, $params, $attribs); ?> </li>
            <?php endif; ?>
            <?php if ($canEdit) : ?>
                <li class="edit-icon"> <?php echo JHtml::_('icon.edit', $article, $params, $attribs); ?> </li>
            <?php endif; ?>
        </ul>
    </div>
        <?php endif; ?>

    <?php else : ?>

    <div class="float-right">
        <?php echo JHtml::_('icon.print_screen', $article, $params); ?>
    </div>

    <?php endif; ?>
</div>