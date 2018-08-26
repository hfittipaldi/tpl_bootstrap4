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
    <link href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/jui/bootstrap-adapter.css'; ?>" rel="stylesheet" />
    <link href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/template.css'; ?>" rel="stylesheet" />
    <?php $userCss = '/templates/' . $this->template . '/css/custom.css'; ?>
    <?php if (is_file(JPATH_ROOT . $userCss)) : ?>

    <link href="<?php echo $this->baseurl . $userCss; ?>" rel="stylesheet" />
    <?php endif; ?>

    <link href="<?php echo $this->baseurl . '/templates/' . $this->template . '/css/error.css'; ?>" rel="stylesheet" />
    <?php if ($params->get('bodyFont')) : // Body Font ?>

    <link href="https://fonts.googleapis.com/css?family=<?php echo $params->get('bodyFontName'); ?>:400,400i,500,500i" rel="stylesheet" />
    <style>
        body {
            font-family: <?php echo str_replace('+', ' ', $params->get('bodyFontName')); ?>;
        }
    </style>
    <?php endif; ?>
    <?php if ($params->get('googleFont')) : // Use of Google Font on titles ?>

    <link href="https://fonts.googleapis.com/css?family=<?php echo $params->get('googleFontName'); ?>" rel="stylesheet" />
    <style>
        h1, h2, h3, h4, h5, h6,
        .h1, .h2, .h3, .h4, .h5, .h6,
        .site-title {
            font-family: <?php echo str_replace('+', ' ', $params->get('googleFontName')); ?>;
        }
    </style>
    <?php endif; ?>
    <?php if ($params->get('navigationFont')) : // Navigation Font ?>

    <link href="https://fonts.googleapis.com/css?family=<?php echo $params->get('navigationFontname'); ?>" rel="stylesheet" />
    <style>
        nav {
            font-family: <?php echo str_replace('+', ' ', $params->get('navigationFontname')); ?>;
        }
    </style>
    <?php endif; ?>

    <script src="<?php echo $this->baseurl . '/media/jui/js/jquery.min.js'; ?>"></script>
    <script src="<?php echo $this->baseurl . '/media/jui/js/jquery-noconflict.js'; ?>"></script>
    <script src="<?php echo $this->baseurl . '/media/jui/js/jquery-migrate.min.js'; ?>"></script>
    <script src="<?php echo $this->baseurl . '/templates/' . $this->template . '/js/jui/bootstrap.min.js'; ?>"></script>
</head>

<body class="site-error">
    <header class="page-header">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="<?php echo $this->baseurl; ?>">
                <?php echo $logo; ?>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsMain" aria-controls="navbarsMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsMain">
                <?php foreach (JModuleHelper::getModules('mainnav') as $module) : ?>
                    <?php echo JModuleHelper::renderModule($module, ['style' => 'none']); ?>
                <?php endforeach; ?>

                <?php foreach (JModuleHelper::getModules('search') as $module) : ?>
                    <?php echo JModuleHelper::renderModule($module, ['style' => 'none']); ?>
                <?php endforeach; ?>

            </div>
        </nav>
    </header>

    <div class="page-body">
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
                            <?php if (JModuleHelper::getModule('mod_search')) : ?>
                            <p><strong><?php echo JText::_('JERROR_LAYOUT_SEARCH'); ?></strong></p>
                            <p><?php echo JText::_('JERROR_LAYOUT_SEARCH_PAGE'); ?></p>
                                <?php $module = JModuleHelper::getModule('mod_search'); ?>
                                <?php echo JModuleHelper::renderModule($module); ?>
                            <?php endif; ?>

                            <p><?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?></p>
                            <p><a href="<?php echo $this->baseurl; ?>" class="btn btn-secondary"><span class="icon-home" aria-hidden="true"></span> <?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></p>
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

    <footer class="page-footer">
        <div class="<?php echo $container; ?>">
            <!-- Begin Copyright -->
            <div class="copyright">
                <?php echo $doc->getBuffer('modules', 'copyright', ['style' => 'none']); ?>
            </div>
            <!-- End Copyright -->
        </div>
    </footer>

    <?php echo $doc->getBuffer('modules', 'debug', ['style' => 'none']); ?>
</body>
</html>
