<?php
/**
 * External Messages.
 * Generate custom transactions messages based on templates to export to third senders
 *
 * @category  Spalenza
 * @package   Spalenza_ExternalMessages
 * @author    Denis Colli Spalenza <deniscsz@gmail.com>
 * @license   https://opensource.org/licenses/OSL-3.0.php Open Software License 3.0
 */

/**
 * Class Spalenza_ExternalMessages_IndexController
 */
class Spalenza_ExternalMessages_IndexController extends Mage_Core_Controller_Front_Action
{
    public function IndexAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }
}