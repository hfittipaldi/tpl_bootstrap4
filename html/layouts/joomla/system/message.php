<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.bootstrap4
 *
 * @copyright   Hugo Fittipaldi (C) 2018. All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE
 */

defined('_JEXEC') or die;

$msgList = $displayData['msgList'];

if (is_array($msgList) && !empty($msgList)) : ?>

<div id="system-message-container">
        <?php foreach ($msgList as $type => $msgs) :
            switch (strtolower($type))
            {
                case 'danger':
                case 'error':
                    $alert = 'danger';
                    break;

                case 'warning':
                    $alert = 'warning';
                    break;

                case 'success':
                    $alert = 'success';
                    break;

                default:
                case 'info':
                case 'notice':
                case 'message':
                    $alert = 'info';
                    break;
            }
        ?>
    <div class="alert alert-<?php echo $alert; ?> alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php if ($msgs) : ?>
            <?php foreach ($msgs as $msg) : ?>

        <div><?php echo $msg; ?></div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>
        <?php endforeach; ?>

</div>
<?php endif; ?>
