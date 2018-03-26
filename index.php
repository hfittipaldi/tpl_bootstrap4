<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.bootstrap4
 *
 * @copyright   Hugo Fittipaldi (C) 2018. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

JHtmlBootstrap::loadCss(true, $this->direction);
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" >
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <jdoc:include type="head" />

    <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template.css" type="text/css" />
</head>

<body>
    <jdoc:include type="modules" name="search" />
    <jdoc:include type="modules" name="mainnanv" />
    <jdoc:include type="modules" name="content-top" />
    <jdoc:include type="message" />
    <jdoc:include type="component" />
    <jdoc:include type="modules" name="content-bottom" />
    <jdoc:include type="modules" name="left" />
    <jdoc:include type="modules" name="right" />
    <jdoc:include type="modules" name="footer" />
    <jdoc:include type="modules" name="debug" />
</body>
</html>
