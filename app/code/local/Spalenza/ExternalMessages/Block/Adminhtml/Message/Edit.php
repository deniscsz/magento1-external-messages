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
 * Class Spalenza_ExternalMessages_Block_Adminhtml_Message_Edit
 */
class Spalenza_ExternalMessages_Block_Adminhtml_Message_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Spalenza_ExternalMessages_Block_Adminhtml_Message_Edit constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = "message_id";
        $this->_blockGroup = "externalmessages";
        $this->_controller = "adminhtml_message";
        $this->_updateButton("save", "label", Mage::helper("externalmessages")->__("Save Item"));
        $this->_updateButton("delete", "label", Mage::helper("externalmessages")->__("Delete Item"));

        $this->_addButton("saveandcontinue", array(
            "label" => Mage::helper("externalmessages")->__("Save And Continue Edit"),
            "onclick" => "saveAndContinueEdit()",
            "class" => "save",
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry("message_data") && Mage::registry("message_data")->getId()) {
            return Mage::helper("externalmessages")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("message_data")->getId()));
        } else {
            return Mage::helper("externalmessages")->__("Add Item");
        }
    }
}