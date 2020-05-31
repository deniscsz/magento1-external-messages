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
 * Class Spalenza_ExternalMessages_Model_Mysql4_Template
 */
class Spalenza_ExternalMessages_Model_Mysql4_Template extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("externalmessages/template", "template_id");
    }
}