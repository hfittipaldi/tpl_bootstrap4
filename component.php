<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.bootstrap4
 *
 * @copyright   Hugo Fittipaldi (C) 2018. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

// Output as HTML5
$this->setHtml5(true);

$this->template_path = $this->baseurl . '/templates/' . $this->template;

// Styles
JHtml::_('stylesheet', 'jui/icomoon.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'jui/bootstrap.min.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'jui/bootstrap-adapter.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'template.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'print.css', array('version' => 'auto', 'relative' => true), array('media' => 'print'));
// Check for a custom CSS template file
JHtml::_('stylesheet', 'custom.css', array('version' => 'auto', 'relative' => true));
// Check for a custom CSS component file
JHtml::_('stylesheet', 'component.css', array('version' => 'auto', 'relative' => true));
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="HandheldFriendly" content="True" />
    <meta name="MobileOptimized" content="320" />
    <link rel="icon" type="image/png" href="<?php echo $this->template_path; ?>/favicon.png" />
    <link rel="apple-touch-icon" href="<?php echo $this->template_path; ?>/images/apple-touch-icon.png" />

    <jdoc:include type="head" />
</head>
<body class="contentpane">
    <jdoc:include type="message" />
    <jdoc:include type="component" />
</body>
</html>
