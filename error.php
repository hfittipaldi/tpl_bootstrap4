<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.bootstrap4
 *
 * @copyright   Hugo Fittipaldi (C) 2018. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

/** @var JDocumentError $this */

$app = JFactory::getApplication();
$doc = JFactory::getDocument();

$doc->setHtml5(true);

$params = $app->getTemplate(true)->params;

// Setting Itemid
$menuItem = $app->getMenu()->getItems('link', 'index.php?option=com_search&view=search', true);
if ($Itemid = $menuItem->id)
{
    $app->input->set('Itemid', $Itemid);
}

// Loading site language
$lang = JFactory::getLanguage();
$lang->load('mod_search');

// Getting sitename
$sitename = htmlspecialchars($app->get('sitename', ''), ENT_QUOTES, 'UTF-8');

// Container
$container = $params->get('layout') ? 'container-fluid' : 'container';

// Logo file or site title param
$logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
if ($params->get('logoFile'))
{
    $logo = '<img src="' . JUri::root() . $params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($params->get('siteTitle'))
{
    $logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($params->get('siteTitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}

if ($params->get('siteDescription'))
{
    $logo .= '<div class="site-description">' . htmlspecialchars($params->get('siteDescription'), ENT_COMPAT, 'UTF-8') . '</div>';
}

// Get navbar options
$looks = 'navbar-light';
if ($params->get('navbarLooks') == 1)
{
    $looks = 'navbar-dark bg-primary';
}
elseif ($params->get('navbarLooks') == 2)
{
    $looks = 'navbar-dark bg-dark';
}

$position = '';
if ($params->get('navbarPosition') == 1)
{
    $position = ' fixed-top';
}
elseif ($params->get('navbarPosition') == 2)
{
    $position = ' fixed-bottom';
}

$behavior = ' navbar-expand-' . $params->get('navbarBehavior', 'md');

$navbar = $looks . $position . $behavior;

$nContainer = (bool) $params->get('navbarContainer');
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" >
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <title><?php echo $this->title; ?> <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="icon" type="image/png" href="<?php echo $this->baseurl . '/templates/' . $this->template; ?>/favicon.png" />
    <link rel="apple-touch-icon" type="image/png" href="<?php echo $this->baseurl . '/templates/' . $this->template; ?>/images/apple-touch-icon.png" />
    <link href="<?php echo $this->baseurl . '/media/jui/css/icomoon.css'; ?>" rel="stylesheet" />
    <link href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/jui/bootstrap.min.css'; ?>" rel="stylesheet" />
    <link href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/template.css'; ?>" rel="stylesheet" />
    <link href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/error.css'; ?>" rel="stylesheet" />
    <?php if ($params->get('bodyFont')) : // Body Font ?>

    <link href="https://fonts.googleapis.com/css?family=<?php echo $params->get('bodyFontName'); ?>:400,700" rel="stylesheet" />
    <style>
        body {
            font-family: <?php echo str_replace('+', ' ', $params->get('bodyFontName')); ?>;
        }
    </style>
    <?php endif; ?>
    <?php if ($params->get('titlesFont')) : // Use of Google Font on titles ?>

    <link href="https://fonts.googleapis.com/css?family=<?php echo $params->get('titlesFontName'); ?>" rel="stylesheet" />
    <style>
        h1, h2, h3, h4, h5, h6,
        .h1, .h2, .h3, .h4, .h5, .h6,
        .site-title {
            font-family: <?php echo str_replace('+', ' ', $params->get('titlesFontName')); ?>;
        }
    </style>
    <?php endif; ?>
</head>

<body class="site-error">
    <header class="tpl-header">
        <nav class="navbar <?php echo $navbar; ?>">
            <?php if ($nContainer === false) : ?>
            <div class="<?php echo $container; ?>">
    <?php endif; ?>

            <a class="navbar-brand" href="<?php echo $this->baseurl; ?>">
                <?php echo $logo; ?>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsMain" aria-controls="navbarsMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsMain">
                <?php
                foreach (JModuleHelper::getModules('mainnav') as $module)
                {
                    $m_params = json_decode($module->params);
                    $script = 'bootstrap-4-navbar.js';
                    if ($m_params->style === 'Bootstrap4-menuHover')
                    {
                        $script = 'bootstrap-4-hover-navbar.js';
                    }
                    echo JModuleHelper::renderModule($module);
                }

                foreach (JModuleHelper::getModules('search') as $module)
                {
                    echo JModuleHelper::renderModule($module);
                }
                ?>

            </div>

            <?php if ($nContainer === false) : ?>
            </div>
            <?php endif; ?>
        </nav>
    </header>

    <div class="tpl-body">
        <div class="<?php echo $container; ?>">
            <h1><?php echo $this->error->getCode(); ?></h1>
            <h2><?php echo JText::_('JERROR_LAYOUT_PAGE_NOT_FOUND'); ?></h2>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class= "col-md-7">
                            <p><strong><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></strong></p>
                            <p><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></p>
                    <ul>
                                <li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
                                <li><?php echo JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
                                <li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
                                <li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
                                <li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
                                <li><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
                    </ul>
                        </div>
                        <div class="col-md-5">
                            <p><strong><?php echo JText::_('JERROR_LAYOUT_SEARCH'); ?></strong></p>
                            <p><?php echo JText::_('JERROR_LAYOUT_SEARCH_PAGE'); ?></p>
                            <form action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-inline mt-1">
                                <div class="input-group">
                                    <input name="searchword" id="mod-search-searchword" maxlength="200" class="form-control search-query" type="search" size="20" aria-label="<?php echo JText::_('MOD_SEARCH_LABEL_TEXT'); ?>" aria-describedby="searchword" placeholder="<?php echo JText::_('MOD_SEARCH_LABEL_TEXT'); ?>">
                                    <div class="input-group-append">
                                        <button class="input-group-text" id="searchword"><span class="icon-search"></span></button>
                                    </div>
                                </div>
                                <input type="hidden" name="task" value="search">
                                <input type="hidden" name="option" value="com_search">
                                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>">
                            </form>

                            <p><?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></p>
                            <p class="mt-1"><a href="<?php echo $this->baseurl; ?>" class="btn btn-secondary"><span class="icon-home" aria-hidden="true"></span> <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></p>
                        </div>
                    </div>

                    <hr />
                    <p><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></p>
                    <blockquote>
                        <span class="badge badge-secondary"><?php echo $this->error->getCode(); ?></span> <?php echo htmlspecialchars($this->error->getMessage(), ENT_QUOTES, 'UTF-8'); ?>
                    </blockquote>
                    <?php if ($this->debug) : ?>
                    <div>
                        <?php echo $this->renderBacktrace(); ?>
                        <?php // Check if there are more Exceptions and render their data as well ?>
                        <?php if ($this->error->getPrevious()) : ?>
                            <?php $loop = true; ?>
                            <?php // Reference $this->_error here and in the loop as setError() assigns errors to this property and we need this for the backtrace to work correctly ?>
                            <?php // Make the first assignment to setError() outside the loop so the loop does not skip Exceptions ?>
                            <?php $this->setError($this->_error->getPrevious()); ?>
                            <?php while ($loop === true) : ?>
                            <p><strong><?php echo JText::_('JERROR_LAYOUT_PREVIOUS_ERROR'); ?></strong></p>
                                <p><?php echo htmlspecialchars($this->_error->getMessage(), ENT_QUOTES, 'UTF-8'); ?></p>
                                <?php echo $this->renderBacktrace(); ?>
                                <?php $loop = $this->setError($this->_error->getPrevious()); ?>
                            <?php endwhile; ?>
                            <?php // Reset the main error object to the base error ?>
                            <?php $this->setError($this->error); ?>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <footer class="tpl-footer">
        <div class="<?php echo $container; ?>">
            <!-- Begin Copyright -->
            <div class="copyright">
                <?php echo $doc->getBuffer('modules', 'copyright', ['style' => 'none']); ?>
            </div>
            <!-- End Copyright -->
        </div>
    </footer>

    <?php echo $doc->getBuffer('modules', 'debug', ['style' => 'none']); ?>

    <script src="<?php echo $this->baseurl . '/media/jui/js/jquery.min.js'; ?>"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/jui/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/' . $script; ?>"></script>
</body>
</html>
