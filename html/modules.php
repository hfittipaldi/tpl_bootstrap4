<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.bootstrap4
 *
 * @copyright   Hugo Fittipaldi (C) 2018. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

/*
 * Module chrome for rendering the module in a submenu
 */
function modChrome_no($module, &$params, &$attribs)
{
    if ($module->content)
    {
        echo $module->content;
    }
}

function modChrome_card($module, &$params, &$attribs)
{
    $modulePos     = $module->position;
    $moduleTag     = $params->get('module_tag', 'div');
    $headerTag     = htmlspecialchars($params->get('header_tag', 'h3'));
    $headerClass   = htmlspecialchars($params->get('header_class', ''));

    if ($module->content)
    {
        echo '<' . $moduleTag . ' class="moduletable ' . $modulePos . ' card ' . htmlspecialchars($params->get('moduleclass_sfx')) . '">';
        echo '<div class="card-body">';
        if ($module->showtitle)
        {
            echo '<' . $headerTag . ' class="card-title ' . $headerClass . '">' . $module->title . '</' . $headerTag . '>';
        }
        echo $module->content;
        echo '</div>';
        echo '</' . $moduleTag . '>';
    }
}

function modChrome_cardHeader($module, &$params, &$attribs)
{
    $modulePos     = $module->position;
    $moduleTag     = $params->get('module_tag', 'div');
    $headerTag     = htmlspecialchars($params->get('header_tag', 'h3'));
    $headerClass   = htmlspecialchars($params->get('header_class', ''));
    $headerClass   = $headerClass ? ' class="' . $headerClass . '"' : '';

    if ($module->content)
    {
        echo '<' . $moduleTag . ' class="moduletable ' . $modulePos . ' card ' . htmlspecialchars($params->get('moduleclass_sfx')) . '">';
        if ($module->showtitle)
        {
            echo '<div class="card-header"><' . $headerTag . $headerClass . '>' . $module->title . '</' . $headerTag . '></div>';
        }
        echo '<div class="card-body">';
        echo $module->content;
        echo '</div>';
        echo '</' . $moduleTag . '>';
    }
}

function modChrome_menuHover($module, &$params, &$attribs)
{
    echo $module->content;
}
