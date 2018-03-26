<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.bootstrap4
 *
 * @copyright   Hugo Fittipaldi (C) 2018. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

// Returns a reference to the application object
$app = JFactory::getApplication();

// Returns a reference to the global document object
$doc = JFactory::getDocument();

// Returns a reference to the user object
$user = JFactory::getUser();

// Returns a reference to the menu object
$menu = $app->getMenu();

// Get the active menu
$menu_active = $menu->getActive();

// Overwrite the language
$this->language = $doc->language;

// Overwrite the text direction
$this->direction = $doc->direction;

// Get the tamplate path
$this->template_path = $this->baseurl . '/templates/' . $this->template;

// Output as HTML5
$doc->setHtml5(true);

// Getting params from template
$tpl_params = $app->getTemplate(true)->params;

// Detecting Active Variables
$jinput   = $app->input;
$option   = $jinput->get('option', '');
$view     = $jinput->get('view', '');
$layout   = $jinput->get('layout', '');
$task     = $jinput->get('task', '');
$itemid   = $jinput->getInt('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename', ''), ENT_QUOTES, 'UTF-8');

// Get pageclass suffix
$pageclass = '';
if (is_object($menu_active))
{
    $pageclass = $menu_active->params->get('pageclass_sfx');
}


// Add Stylesheets
JHtmlBootstrap::loadCss(true, $this->direction);
$doc->addStyleSheet('media/jui/css/icomoon.css');
$doc->addStyleSheetVersion('templates/' . $this->template . '/css/template.css');

// Check for a custom CSS file
JHtml::_('stylesheet', 'custom.css', array('version' => 'auto', 'relative' => true));

// Check for a custom js file
JHtml::_('script', 'custom.js', array('version' => 'auto', 'relative' => true));

// Unset Stylesheets
// Avoid conflict with joomla's bootstrap default
unset($doc->_styleSheets[$this->baseurl . '/media/jui/css/bootstrap-responsive.min.css']);
