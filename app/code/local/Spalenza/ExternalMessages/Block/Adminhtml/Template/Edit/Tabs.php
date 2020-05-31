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
 * Class Spalenza_ExternalMessages_Block_Adminhtml_Template_Edit_Tabs
 */
class Spalenza_ExternalMessages_Block_Adminhtml_Template_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    /**
     * Spalenza_ExternalMessages_Block_Adminhtml_Template_Edit_Tabs constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId("template_tabs");
        $this->setDestElementId("edit_form");
        $this->setTitle(Mage::helper("externalmessages")->__("Item Information"));
    }

    /**
     * @return Mage_Core_Block_Abstract
     * @throws Exception
     */
    protected function _beforeToHtml()
    {
        $this->addTab("form_section", array(
            "label" => Mage::helper("externalmessages")->__("Item Information"),
            "title" => Mage::helper("externalmessages")->__("Item Information"),
            "content" => $this->getLayout()->createBlock("externalmessages/adminhtml_template_edit_tab_form")->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
