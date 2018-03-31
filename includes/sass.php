<?php
/**
 * @package     Joomla.Site
 * @subpackage  Include.Sass
 *
 * @copyright   Hugo Fittipaldi (C) 2018. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

$composerAutoload = dirname(__DIR__) . '/vendor/autoload.php';

if (!file_exists($composerAutoload))
{
    return;
}

require_once $composerAutoload;

use Phproberto\Sass\FileCompiler;

$scssFolder  = dirname(__DIR__) . '/scss';
$cssFolder   = dirname(__DIR__) . '/css/jui';
$cacheFolder = JPATH_ROOT . '/cache';

require_once 'variables.php';

$scss = new FileCompiler($cacheFolder);

try
{
    $scss->compileFile($scssFolder . '/bootstrap.scss', $cssFolder . '/bootstrap.min.css', FileCompiler::FORMATTER_EXPANDED);
    $scss->compileFile($scssFolder . '/bootstrap-adapter.scss', $cssFolder . '/bootstrap-adapter.css', FileCompiler::FORMATTER_EXPANDED);
}
catch (Exception $e)
{
    JFactory::getApplication()->enqueueMessage('Error compiling Sass: ' . $e->getMessage(), 'error');
}

if (!$scss->isCachedCompilation())
{
    $message = 'Sass successfully compiled. Time elapsed ' . $scss->getTimeElapsed() . ' seconds';

    JFactory::getApplication()->enqueueMessage($message, 'success');
}
