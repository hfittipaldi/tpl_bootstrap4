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
require_once JPATH_THEMES . '/' . $template . '/code/com_content/helpers/query.php';

JHtml::_('behavior.caption');

$dispatcher = JEventDispatcher::getInstance();

$this->category->text = $this->category->description;
$dispatcher->trigger('onContentPrepare', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$this->category->description = $this->category->text;

$results = $dispatcher->trigger('onContentAfterTitle', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayTitle = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentBeforeDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$beforeDisplayContent = trim(implode("\n", $results));

$results = $dispatcher->trigger('onContentAfterDisplay', array($this->category->extension . '.categories', &$this->category, &$this->params, 0));
$afterDisplayContent = trim(implode("\n", $results));

$doc = JFactory::getDocument();

$item_col   = 'col-sm';
$min_width  = 768;
if ($doc->countModules('left') || $doc->countModules('right'))
{
    $item_col   = 'col-md';
    $min_width  = 992;
}

// Check if the order is column (0) or row (1)
$order = (int) $this->params->get('multi_column_order');

// Define number of columns
$n_columns = (int) $this->columns;

if ($n_columns > 1)
{
    $layout =  'across';
}
$style_declaration = "
        .blog .items-intro.across .item {
                max-width: " . 100 / $n_columns . "%;
        }";


if ($order === 0)
{
    $style_declaration = "
        .blog .items-intro.down {
            -webkit-column-count: " . $n_columns . " !important;
                    column-count: " . $n_columns . " !important;
        }";

    if ($n_columns > 1)
    {
        $layout = 'down';
        $this->intro_items = ContentHelperQueryCustom::revertArticlesOrder($this->intro_items, $n_columns);
    }
}

if ($n_columns > 2)
{
    $doc->addStyleDeclaration("
    @media (min-width: " . $min_width . "px) {" .
        $style_declaration
    . "}");
}

// If the page class is defined, add to class as suffix.
// It will be a separate class if the user starts it with a space
?>
<div class="blog" itemscope itemtype="https://schema.org/Blog">
    <?php if ($this->params->get('show_page_heading')) : ?>
    <div class="page-header">
            <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
        </div>
    <?php endif; ?>

    <?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
        <h2> <?php echo $this->escape($this->params->get('page_subheading')); ?>
            <?php if ($this->params->get('show_category_title')) : ?>
                <span class="subheading-category"><?php echo $this->category->title; ?></span>
            <?php endif; ?>
        </h2>
    <?php endif; ?>
    <?php echo $afterDisplayTitle; ?>

    <?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
        <?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
        <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
    <?php endif; ?>

    <?php if ($beforeDisplayContent || $afterDisplayContent || $this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
        <div class="category-desc clearfix">
            <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
                <img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>"/>
            <?php endif; ?>
            <?php echo $beforeDisplayContent; ?>
            <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                <?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
            <?php endif; ?>
            <?php echo $afterDisplayContent; ?>
    </div>
    <?php endif; ?>

    <?php if (empty($this->lead_items) && empty($this->link_items) && empty($this->intro_items)) : ?>
        <?php if ($this->params->get('show_no_articles', 1)) : ?>
            <p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <?php $leadingcount = 0; ?>
    <?php if (!empty($this->lead_items)) : ?>
    <section class="items items-leading">
    <?php foreach ($this->lead_items as &$item) : ?>

        <div class="item leading-<?php echo $leadingcount . ($item->state == 0 ? ' system-unpublished' : null); ?>">
            <article itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                <?php
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                ?>
            </article>
        </div>
        <?php $leadingcount++; ?>
    <?php endforeach; ?>

    </section><!-- end items-leading -->
<?php endif; ?>

<?php
if (!empty($this->intro_items)) :
    // Count the number of featured items
    $total = $introcount = count($this->intro_items);
    $i = $counter = 0;
?>
    <section class="items items-intro <?php echo $layout; ?>">
    <?php foreach ($this->intro_items as $key => &$item) :
        $rowcount = ($key % $n_columns) + 1;
        $counter++;

        $first = '';
        if ($order === 0 && $i > 0)
        {
            if ($i === $total / 2)
            {
                $first .= ' item-first--2-col';
            }

            if ($counter % ceil($introcount / $n_columns) === 1)
            {
                $first .= ' item-first--n-col';
            }
        }
        ?>

        <div class="item item-<?php echo $i++ . $first . ($item->state == 0 ? ' system-unpublished' : null) . ' ' . $item_col; ?>">
            <article itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                <?php
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                ?>
            </article>
        </div>

        <?php
        // Check if the layout is row
        // Check if it isn't the last article
        if ($order === 1 && $counter !== $introcount) :
            // Split row into 2 articles
            if ($counter % 2 === 0) : ?>

        <!-- Split row into 2 columns and add the extra clearfix for only the required viewport -->
        <div class="clear-2-col"></div>
            <?php endif;
            // Check if the article is the last in row
            if ($rowcount === $n_columns) : ?>

        <!-- Split row into n columns only in the required viewport -->
        <div class="clear-n-col"></div>
            <?php endif;
        endif;
    endforeach;

    $empty = $n_columns - $total % $n_columns;
    if ($empty < $n_columns) {
        for ($i = 0; $i < $empty; ++$i) {
    ?>

        <div class="item item-empty <?php echo $item_col; ?>"></div>
    <?php
        }
    }
    ?>

    </section>
<?php endif; ?>

<?php if (!empty($this->link_items)) : ?>
    <hr />

    <div class="items-more">
    <?php echo $this->loadTemplate('links'); ?>
    </div>
<?php endif; ?>

    <?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
        <div class="cat-children">
            <?php if ($this->params->get('show_category_heading_title_text', 1) == 1) : ?>
                <h3> <?php echo JText::_('JGLOBAL_SUBCATEGORIES'); ?> </h3>
            <?php endif; ?>
            <?php echo $this->loadTemplate('children'); ?> </div>
    <?php endif; ?>
    <?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
    <div class="pagination">

        <?php if ($this->params->def('show_pagination_results', 1)) : ?>
        <p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
        <?php  endif; ?>

        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>

</div>
