<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_ROOT . '/components/com_content/helpers');
//JHtml::addIncludePath(JPATH_THEMES . '/' . $template . '/code/com_content/helpers');

JHtml::_('behavior.caption');
?>
<div class="category-list">

    <?php
    $this->subtemplatename = 'articles';
    echo JLayoutHelper::render('joomla.content.category_default', $this);
    ?>

</div>
