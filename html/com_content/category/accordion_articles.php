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

$user = JFactory::getUser();

// Create some shortcuts.
$params = &$this->params;

// Check for at least one editable article
$isEditable = false;

if (!empty($this->items))
{
    foreach ($this->items as $article)
    {
        if ($article->params->get('access-edit'))
        {
            $isEditable = true;
            break;
        }
    }
}

JFactory::getDocument()->addScriptDeclaration("
        var resetFilter = function() {
        document.getElementById('filter-search').value = '';
    }
");
?>

<?php if (empty($this->items)) : ?>
    <?php if ($params->get('show_no_articles', 1)) : ?>
<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
    <?php endif; ?>

<?php else : ?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
    <?php if ($params->get('filter_field') !== 'hide' || $params->get('show_pagination_limit')) : ?>
    <fieldset class="filters">
        <legend class="sr-only"><?php echo JText::_('COM_CONTENT_FORM_FILTER_LEGEND'); ?></legend>
        <div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
            <div class="input-group" role="group" aria-label="Filter field">
            <?php if ($params->get('filter_field') !== 'hide') : ?>
                <?php if ($this->params->get('filter_field') !== 'tag') : ?>

                <input type="text" class="form-control" placeholder="<?php echo JText::_('COM_CONTENT_' . $this->params->get('filter_field') . '_FILTER_LABEL'); ?>" aria-label="Input filter">
                <div class="input-group-append">
                    <button type="button" name="filter-search-button" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>" onclick="document.adminForm.submit();" class="btn input-group-text"><span class="icon-search"></span></button>
                    <button type="reset" name="filter-clear-button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="resetFilter(); document.adminForm.submit();" class="btn input-group-text"><span class="icon-remove"></span></button>
                </div>
                <?php else : ?>

                <select name="filter_tag" id="filter_tag" onchange="document.adminForm.submit();" >
                    <option value=""><?php echo JText::_('JOPTION_SELECT_TAG'); ?></option>
                    <?php echo JHtml::_('select.options', JHtml::_('tag.options', true, true), 'value', 'text', $this->state->get('filter.tag')); ?>
                </select>
                <?php endif; ?>
            <?php endif; ?>
            </div>

            <?php if ($params->get('show_pagination_limit')) : ?>
            <div class="btn-group" role="group" aria-label="Pagination limit">
                <label for="limit" class="sr-only"><?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?></label>
                <?php echo $this->pagination->getLimitBox(); ?>
            </div>
            <?php endif; ?>
        </div>

        <input type="hidden" name="filter_order" value="" />
        <input type="hidden" name="filter_order_Dir" value="" />
        <input type="hidden" name="limitstart" value="" />
        <input type="hidden" name="task" value="" />
    </fieldset>
    <?php endif; ?>

    <div id="accordion" class="card-accordion" role="tablist" aria-multiselectable="true">
        <?php $first = $params->get('show_first_open', 0);
        $data_parent = $params->get('collapse_all', 1)
            ? ' data-parent="#accordion"'
            : '';

        foreach ($this->items as $i => $article)
        {
            $params   = $article->params;
            $info     = $params->get('info_block_position', 0);
            $show     = '';
            $expanded = 'false';

            if ($first == 1 && $i == 0)
            {
                $show = ' show';
                $expanded = 'true';
            }
        ?>
        <article class="card">
            <div class="card-header toggler" id="heading-<?php echo $i; ?>" role="tab">
                <h1><a role="button" data-toggle="collapse" href="#collapse-<?php echo $i; ?>" aria-expanded="<?php echo $expanded; ?>" aria-controls="collapse-<?php echo $i; ?>"><?php echo $this->escape($article->title); ?></a></h1>
            </div>
            <div id="collapse-<?php echo $i; ?>" class="collapse<?php echo $show; ?>" role="tabpanel"<?php echo $data_parent; ?> aria-labelledby="heading-<?php echo $i; ?>">
                <div class="card-body">
                    <?php if ($params->get('show_print_icon') || $params->get('show_email_icon')) : ?>
                    <?php echo JLayoutHelper::render('joomla.content.icons', array('params' => $params, 'item' => $article, 'print' => false)); ?>
                    <?php endif; ?>

                    <?php // Todo Not that elegant would be nice to group the params ?>
                    <?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
                    || $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') ); ?>

                    <?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
                        <?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $article, 'params' => $params, 'position' => 'above')); ?>
                    <?php endif; ?>

                    <?php
                    if ($params->get('access-view'))
                    {
                        echo $article->event->beforeDisplayContent;

                        echo JLayoutHelper::render('joomla.content.full_image', $article);

                        if ($article->fulltext !== null)
                        {
                            $article->text = $article->fulltext;
                            if ($params->get('show_intro'))
                            {
                                $article->text = $article->introtext . $article->fulltext;
                            }
                        }

                        echo JHtml::_('content.prepare', $article->text, '', 'com_content.article');

                        echo $article->event->afterDisplayContent;
                    }
                    elseif ($params->get('show_noauth') == true && $user->get('guest'))
                    {
                        echo JLayoutHelper::render('joomla.content.intro_image', $article);

                        echo JHtml::_('content.prepare', $article->introtext);

                        if ($params->get('show_readmore') && $article->fulltext !== null)
                        {
                            $link = new JUri(JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId, false));
                            $link->setVar('return', base64_encode(ContentHelperRoute::getArticleRoute($article->slug, $article->catid, $article->language)));

                            echo JLayoutHelper::render('joomla.content.readmore', array('item' => $article, 'params' => $params, 'link' => $link));
                        }
                    }
                    ?>

                    <?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
                        <?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $article, 'params' => $params, 'position' => 'below')); ?>
                        <?php if ($params->get('show_tags', 1) && !empty($article->tags->itemTags)) : ?>
                            <?php $article->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
                            <?php echo $article->tagLayout->render($article->tags->itemTags); ?>
                        <?php endif; ?>
                    <?php endif; ?>

                </div>
            </div>
        </article>
        <?php } ?>
    </div>
<?php endif; ?>

<?php // Code to add a link to submit an article. ?>
<?php if ($this->category->getParams()->get('access-create')) : ?>
    <div class="btn-toolbar">
        <?php echo JHtml::_('icon.create', $this->category, $this->category->params); ?>
    </div>
<?php  endif; ?>

<?php // Add pagination links ?>
<?php if (!empty($this->items)) : ?>
    <?php if (($params->def('show_pagination', 2) == 1  || ($params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
    <div class="pagination">
        <?php if ($params->def('show_pagination_results', 1)) : ?>
        <p class="counter pull-right">
            <?php echo $this->pagination->getPagesCounter(); ?>
        </p>
        <?php endif; ?>

        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
    <?php endif; ?>
</form>
<?php  endif; ?>
