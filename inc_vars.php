<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.bootstrap4
 *
 * @copyright   Hugo Fittipaldi (C) 2018. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

$doc = JFactory::getDocument();

JHtmlBootstrap::loadCss(true, $this->direction);
$doc->addStyleSheet($this->baseurl . '/media/jui/css/icomoon.css');

// Unset Stylesheets
// Avoid conflict with joomla's bootstrap default
unset($doc->_styleSheets[$this->baseurl . '/media/jui/css/bootstrap-responsive.min.css']);
