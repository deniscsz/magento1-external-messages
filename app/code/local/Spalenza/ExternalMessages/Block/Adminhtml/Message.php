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
 * Class Spalenza_ExternalMessages_Block_Adminhtml_Message
 */
class Spalenza_ExternalMessages_Block_Adminhtml_Message extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = "adminhtml_message";
        $this->_blockGroup = "externalmessages";
        $this->_headerText = Mage::helper("externalmessages")->__("Message Manager");
        $this->_addButtonLabel = Mage::helper("externalmessages")->__("Add New Item");
        parent::__construct();
    }
}