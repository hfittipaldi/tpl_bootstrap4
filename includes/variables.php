<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.bootstrap4
 *
 * @copyright   Hugo Fittipaldi (C) 2018. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

$file  = $scssFolder . '/partials/_variables.scss';
$cache = $cacheFolder . '/_variables.scss';

$vars  = '$primary: '           . $tpl_params->get('primary', '#007bff') . ";\n";
$vars .= '$body-bg: '           . $tpl_params->get('body_bg', '#ffffff') . ";\n";
$vars .= '$body-color: '        . $tpl_params->get('body_color', '#212529') . ";\n";
$vars .= '$enable-shadows: '    . ($tpl_params->get('enable_shadows', 0) ? 'true' : 'false') . ";\n";
$vars .= '$enable-gradients: '  . ($tpl_params->get('enable_gradients', 0) ? 'true' : 'false') . ";\n";
$vars .= '$navbarBg: '          . ($tpl_params->get('navbarLooks') == 0
                                   ? $tpl_params->get('navbarBg', '#ffffff')
                                   : 'false') . ";\n";
$vars .= '$navbarPos: '         . $tpl_params->get('navbarPosition', 0) . ";\n";
$vars .= '$breakpoint: '        . $tpl_params->get('navbarBehavior', 'md') . ";\n";
$vars .= '$bodyFont: '          . "'" . $bodyFont . "';\n";
$vars .= '$titlesFont: '        . "'" . $titlesFont . "';\n";

$fp = fopen($cache, "w");
$write = fwrite($fp,  $vars);
fclose($fp);

$old = md5_file($file);
$new = md5_file($cache);

if ($old !== $new)
{
    $fp  = fopen($file, "w");
    $write = fwrite($fp, $vars);
    fclose($fp);
}
