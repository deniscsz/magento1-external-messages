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
 * Class Spalenza_ExternalMessages_Block_Adminhtml_Message_Edit_Tab_Form
 */
class Spalenza_ExternalMessages_Block_Adminhtml_Message_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("externalmessages_form",
            array("legend" => Mage::helper("externalmessages")->__("Item information"))
        );

        $fieldset->addField("message", "text", array(
            "label" => Mage::helper("externalmessages")->__("Message"),
            "class" => "required-entry",
            "required" => true,
            "name" => "message",
        ));

        $fieldset->addField("recipient", "text", array(
            "label" => Mage::helper("externalmessages")->__("Recipient"),
            "class" => "required-entry",
            "required" => true,
            "name" => "recipient",
        ));

        $fieldset->addField("type", "text", array(
            "label" => Mage::helper("externalmessages")->__("Type"),
            "class" => "required-entry",
            "required" => true,
            "name" => "type",
        ));


        if (Mage::getSingleton("adminhtml/session")->getMessageData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getMessageData());
            Mage::getSingleton("adminhtml/session")->setMessageData(null);
        } elseif (Mage::registry("message_data")) {
            $form->setValues(Mage::registry("message_data")->getData());
        }

        return parent::_prepareForm();
    }
}
