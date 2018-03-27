<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.bootstrap4
 *
 * @copyright   Hugo Fittipaldi (C) 2018. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

/**
 * This is a file to add template specific chrome to pagination rendering.
 *
 * pagination_list_footer
 *  Input variable $list is an array with offsets:
 *      $list[limit]        : int
 *      $list[limitstart]   : int
 *      $list[total]        : int
 *      $list[limitfield]   : string
 *      $list[pagescounter] : string
 *      $list[pageslinks]   : string
 *
 * pagination_list_render
 *  Input variable $list is an array with offsets:
 *      $list[all]
 *          [data]      : string
 *          [active]    : boolean
 *      $list[start]
 *          [data]      : string
 *          [active]    : boolean
 *      $list[previous]
 *          [data]      : string
 *          [active]    : boolean
 *      $list[next]
 *          [data]      : string
 *          [active]    : boolean
 *      $list[end]
 *          [data]      : string
 *          [active]    : boolean
 *      $list[pages]
 *          [{PAGE}][data]      : string
 *          [{PAGE}][active]    : boolean
 *
 * pagination_item_active
 *  Input variable $item is an object with fields:
 *      $item->base    : integer
 *      $item->link    : string
 *      $item->text    : string
 *
 * pagination_item_inactive
 *  Input variable $item is an object with fields:
 *      $item->base    : integer
 *      $item->link    : string
 *      $item->text    : string
 *
 * This gives template designers ultimate control over how pagination is rendered.
 *
 * NOTE: If you override pagination_item_active OR pagination_item_inactive you MUST override them both
 */

/**
 * Renders the pagination footer
 *
 * @param   array   $list  Array containing pagination footer
 *
 * @return  string         HTML markup for the full pagination footer
 *
 * @since   3.0
 */
function pagination_list_footer($list)
{
    $html = '<div class="pagination-links">' . PHP_EOL;
    $html .= $list['pageslinks'] . PHP_EOL;
    $html .=  '<input type="hidden" name="' . $list['prefix'] . 'limitstart" value="' . $list['limitstart'] . '" />' . PHP_EOL;
    $html .=  '</div>' . PHP_EOL;

    return $html;
}

/**
 * Override joomla default pagination list render method. By default, joomla display 10 pages in pagination.
 *
 * @param   array   $list  Array containing pagination information
 *
 * @return  string         HTML markup for the full pagination object
 */
function pagination_list_render($list)
{
    $displayedPages = 6;

    // Reduce number of displayed pages to 6 instead of 10
    $list['pages'] = _reduce_displayed_pages($list['pages'], $displayedPages);

    return _list_render($list);
}

/**
 * Reduce number of displayed pages in pagination
 *
 * @param  array	$pages			Pagination pages raw data
 *
 * @param  integer	$displayedPages	Number of displayed pages
 *
 * @return string					HTML string
 */
function _reduce_displayed_pages($pages, $displayedPages)
{
    $currentPageIndex = _get_current_page_index($pages);
    $midPoint = ceil($displayedPages / 2);

    if ($currentPageIndex >= $displayedPages)
    {
        $pages = array_slice($pages, -$displayedPages, null, true);
    }
    else
    {
        $startIndex = max($currentPageIndex - $midPoint, 0);
        $pages = array_slice($pages, $startIndex, $displayedPages, true);
    }

    return $pages;
}

/**
 * Get current page index
 *
 * @param  array	$pages	Pagination pages raw data
 *
 * @return integer			Current page index
 */
function _get_current_page_index($pages)
{
    $counter = 0;
    foreach ($pages as $page)
    {
        if (!$page['active'])
        {
            return $counter;
        }
        $counter++;
    }
}

/**
 * Function copied from joomla html pagination to render pagination data into html string
 *
 * @param  array	$list	Pagination raw data
 *
 * @return string			HTML string
 */
function _list_render($list)
{
    $html  = '<nav aria-label="' . JText::_('JLIB_HTML_PAGINATION') . '">' . PHP_EOL;
    $html .= '    <ul class="pagination">' . PHP_EOL;
    $html .= $list['start']['data'] . PHP_EOL;
    $html .= $list['previous']['data'] . PHP_EOL;

    foreach ($list['pages'] as $page)
    {
        $html .= $page['data'] . PHP_EOL;
    }

    $html .= $list['next']['data'] . PHP_EOL;
    $html .= $list['end']['data'] . PHP_EOL;

    $html .= '    </ul>' . PHP_EOL;
    $html .= '</nav>' . PHP_EOL;

    return $html;
}

/**
 * Renders an active item in the pagination block
 *
 * @param   JPaginationObject  $item  The current pagination object
 *
 * @return  string                    HTML markup for active item
 *
 * @since   3.0
 */
function pagination_item_active(&$item)
{
    $session = JFactory::getSession();
    $app     = JFactory::getApplication();
    $menu    = $app->getMenu()->getActive();
    $params  = JComponentHelper::getParams('com_content');

    $num_items = $menu->params->get('num_leading_articles') + $menu->params->get('num_intro_articles');
    if ($menu->params->get('num_leading_articles') == 0)
    {
        $num_items += $params->get('num_leading_articles');
    }

    if ($menu->params->get('num_intro_articles') == 0)
    {
        $num_items += $params->get('num_intro_articles');
    }

    if ($menu->query['view'] === 'search' || $menu->params->get('display_num'))
    {
        $name  = 'factor_' . $menu->id;
        $limit = $app->input->get('limit');
        if (!empty($limit))
        {
            $session->set($name, $limit);
        }

        $num_items = $session->get($name);
        if (empty($num_items))
        {
            $num_items = $menu->params->get('display_num');
            if (empty($num_items))
            {
                $num_items = $app->getCfg('list_limit');
            }
        }
    }

    $class = '';
    $rel   = '';
    $aria  = '';
    $page  = ceil($item->base / $num_items) + 1;
    $title = sprintf(JText::_('JLIB_HTML_PAGE_CURRENT'), '#' . $page);

    // Check for "Start" item
    if ($item->text === JText::_('JLIB_HTML_START'))
    {
        $display = '&laquo;';
        $aria    = ' aria-label="First"';
        $title   = $item->text . ': ' . $title;
    }

    // Check for "Prev" item
    if ($item->text === JText::_('JPREV'))
    {
        $item->text = JText::_('JPREVIOUS');
        $display    = '&lsaquo;';
        $rel        = ' rel="' . $item->text . '"';
        $aria       = ' aria-label="Previous"';
        $title      = $item->text . ': ' . $title;
    }

    // Check for "Next" item
    if ($item->text === JText::_('JNEXT'))
    {
        $display = '&rsaquo;';
        $rel     = ' rel="' . $item->text . '"';
        $aria    = ' aria-label="Next"';
        $title   = $item->text . ': ' . $title;
    }

    // Check for "End" item
    if ($item->text === JText::_('JLIB_HTML_END'))
    {
        $display = '&raquo;';
        $aria    = ' aria-label="Last"';
        $title   = $item->text . ': ' . $title;
    }

    // If the display object isn't set already, just render the item with its text
    if (!isset($display))
    {
        $display    = '<span class="sr-only">' . sprintf(JText::_('JLIB_HTML_PAGE_CURRENT'), '#') . '</span>' . $item->text;
        $class      = ' class="page-item"';
    }

    return '<li' . $class . '><a title="' . $title . '" href="' . $item->link . '" class="page-link pagenav hasTooltip"' . $rel . $aria . '>' . $display . '</a></li>';
}

/**
 * Renders an inactive item in the pagination block
 *
 * @param   JPaginationObject  $item  The current pagination object
 *
 * @return  string  HTML markup for inactive item
 *
 * @since   3.0
 */
function pagination_item_inactive(&$item)
{
    // Check for "Start" item
    if ($item->text === JText::_('JLIB_HTML_START'))
    {
        return '<li class="page-item disabled"><a href="#" class="page-link" aria-label="First" tabindex="-1"><span aria-hidden="true">&laquo;</span></a></li>';
    }

    // Check for "Prev" item
    if ($item->text === JText::_('JPREV'))
    {
        return '<li class="page-item disabled"><a href="#" class="page-link" aria-label="Previous" type="prev" tabindex="-1"><span aria-hidden="true">&lsaquo;</span></a></li>';
    }

    // Check for "Next" item
    if ($item->text === JText::_('JNEXT'))
    {
        return '<li class="page-item disabled"><a href="#" class="page-link" aria-label="Next" type="next" tabindex="-1"><span aria-hidden="true">&rsaquo;</span></a></li>';
    }

    // Check for "End" item
    if ($item->text === JText::_('JLIB_HTML_END'))
    {
        return '<li class="page-item disabled"><a href="#" class="page-link" aria-label="Last" tabindex="-1"><span aria-hidden="true">&raquo;</span></a></li>';
    }

    // Check if the item is the active page
    if (isset($item->active) && $item->active)
    {
        $aria = JText::sprintf('JLIB_HTML_PAGE_CURRENT', '#' . $item->text);

        return '<li class="page-item active"><a class="page-link" aria-current="true" aria-label="' . $aria . '"><span class="sr-only">(current)</span>' . $item->text . '</a></li>';
    }

    // Doesn't match any other condition, render a normal item
    return '<li class="page-item disabled"><a class="page-link" tabindex="-1">' . $item->text . '</a></li>';
}
