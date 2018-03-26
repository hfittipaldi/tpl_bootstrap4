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


// Template colors
if ($params->get('body_bg') || $params->get('body_color'))
{ ?>
    body {
        <?php echo $params->get('body_color') ? 'color: ' . $params->get('body_color') . ';' . PHP_EOL; ?>
        <?php echo $params->get('body_bg') ? 'background-color: ' . $params->get('body_color') . ';' . PHP_EOL; ?>
    }
<?php }

// Body Font
if ($params->get('bodyFont'))
{
        JHtml::_('stylesheet', '//fonts.googleapis.com/css?family=' . $params->get('bodyFontName'));
        $this->addStyleDeclaration("
    body {
        font-family: '" . str_replace('+', ' ', $params->get('bodyFontName')) . "';
    }");
}
// Use of Google Font on titles
if ($params->get('googleFont'))
{
    JHtml::_('stylesheet', '//fonts.googleapis.com/css?family=' . $params->get('googleFontName'));
    $this->addStyleDeclaration("
    h1, h2, h3, h4, h5, h6,
    .h1, .h2, .h3, .h4, .h5, .h6,
    .site-title {
        font-family: '" . str_replace('+', ' ', $params->get('googleFontName')) . "';
    }");
}
// Navigation Font
if ($params->get('navigationFont'))
{
        JHtml::_('stylesheet', '//fonts.googleapis.com/css?family=' . $params->get('navigationFontname'));
        $this->addStyleDeclaration("
    nav {
        font-family: '" . str_replace('+', ' ', $params->get('navigationFontname')) . "';
    }");
}

// Get template layout
$container  = 'container';
$container .= !$params->get('layout') ? '' : '-fluid';

// Adjusting layout
if ($this->countModules('left') && $this->countModules('right'))
{
    $wrapper = 'wrapper--lft-rgt ';
}
elseif ($this->countModules('left'))
{
    $wrapper = 'wrapper--lft ';
}
elseif ($this->countModules('right'))
{
    $wrapper = 'wrapper--rgt ';
}
else
{
    $wrapper = '';
}

// Logo file or site title param
if ($params->get('logoFile'))
{
    $logo = '<img src="' . JUri::root() . $params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($params->get('siteTitle'))
{
    $logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($params->get('siteTitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
    $logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}


/**
 * Add current browser information
 * IE:
 * 11 => Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko
 * 10 => Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)
 * 9  => Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)
 * 8  => Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)
 */

$nav = JBrowser::getInstance();
$agent = $nav->getAgentString();
$browserType = $nav->getBrowser();
$browserVersion = $nav->getMajor();
$browser = '';
if ($nav->isMobile() || strpos($agent, 'Mobile'))
{
    $browser = ' Mob';
}

if ($browserType == 'firefox')
{
    $browser .= ' Moz';
}
elseif ($browserType == 'safari')
{
    $browser .= ' Webkit';
}
elseif ($browserType == 'msie')
{
    $browser .= ' IE';
    if ($browserVersion < 10)
    {
        $browser .= ' IE-old';
    }
    elseif ($browserVersion == 10)
    {
        $browser .= ' IE10';
    }
    else
    {
        $browser .= ' IE11';
    }
}
elseif ($browserType == 'edge' && $browserVersion < 16)
{
    $browser .= ' Edge';
}

