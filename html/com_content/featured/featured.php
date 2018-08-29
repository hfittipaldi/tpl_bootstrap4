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

JHtml::_('behavior.caption');

$doc = JFactory::getDocument();

$item_col   = 'col-sm';
$min_width  = 768;
if ($doc->countModules('left') || $doc->countModules('right'))
{
    $item_col   = 'col-md';
    $min_width  = 992;
}

// Check if the layout is column (0) or row (1)
$layout = (int) $this->params->get('multi_column');

// Define number of columns
$n_columns = (int) $this->columns;

$layout_class =  'across';
$style_declaration = "
        .blog-featured .items-intro.across .item {
            max-width: " . 100 / $n_columns . "%;
        }";


if ($layout === 0)
{
    $layout_class = 'down';
    $style_declaration = "
        .blog-featured .items-intro.down {
            -webkit-column-count: " . $n_columns . " !important;
                    column-count: " . $n_columns . " !important;
        }";
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
<div class="blog-featured" itemscope itemtype="https://schema.org/Blog">
    <?php if ($this->params->get('show_page_heading') != 0) : ?>
    <div class="page-header">
        <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
    </div>
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
    $counter = 0;
?>
    <section class="items items-intro <?php echo $layout_class; ?> row">
    <?php foreach ($this->intro_items as $key => &$item) :
        $key = $key - $leadingcount;
        $rowcount = ($key % $n_columns) + 1;
        $counter++;

        $first = '';
        if ($layout === 0 && $key > 0)
        {
            if ($key === $total / 2)
            {
                $first .= ' item-first--2-col';
            }

            if ($counter % ceil($introcount / $n_columns) === 1)
            {
                $first .= ' item-first--n-col';
            }
        }
        ?>

        <div class="item item-<?php echo $key . $first . ($item->state == 0 ? ' system-unpublished' : null) . ' ' . $item_col; ?>">
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
        if ($layout === 1 && $counter !== $introcount) :
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
    endforeach; ?>

    </section>
<?php endif; ?>

<?php if (!empty($this->link_items)) : ?>
    <hr />

    <div class="items-more">
    <?php echo $this->loadTemplate('links'); ?>
    </div>
<?php endif; ?>

<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->pagesTotal > 1)) : ?>
    <div class="pagination">

        <?php if ($this->params->def('show_pagination_results', 1)) : ?>
        <p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
        <?php  endif; ?>

        <?php echo $this->pagination->getPagesLinks(); ?>
    </div>
<?php endif; ?>

</div>
