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
 * Class Spalenza_ExternalMessages_Block_Adminhtml_Template_Edit_Tab_Form
 */
class Spalenza_ExternalMessages_Block_Adminhtml_Template_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("externalmessages_form", array("legend" => Mage::helper("externalmessages")->__("Item information")));

        $fieldset->addField("title", "text", array(
            "label" => Mage::helper("externalmessages")->__("Title"),
            "class" => "required-entry",
            "required" => true,
            "name" => "title",
        ));

        $fieldset->addField("content", "textarea", array(
            "label" => Mage::helper("externalmessages")->__("Template"),
            "class" => "required-entry",
            "required" => true,
            "name" => "content",
        ));

        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('externalmessages')->__('Enabled'),
            'values' => Spalenza_ExternalMessages_Block_Adminhtml_Template_Grid::getValueStatus(),
            'name' => 'status',
            "class" => "required-entry",
            "required" => true,
        ));

        $fieldset->addField('rule', 'select', array(
            'label' => Mage::helper('externalmessages')->__('Rule'),
            'values' => Spalenza_ExternalMessages_Block_Adminhtml_Template_Grid::getValueRules(),
            'name' => 'rule',
        ));

        if (Mage::getSingleton("adminhtml/session")->getTemplateData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getTemplateData());
            Mage::getSingleton("adminhtml/session")->setTemplateData(null);
        } elseif (Mage::registry("template_data")) {
            $form->setValues(Mage::registry("template_data")->getData());
        }
        return parent::_prepareForm();
    }
}
