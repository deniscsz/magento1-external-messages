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
 * Class Spalenza_ExternalMessages_Block_Adminhtml_Message_Grid
 */
class Spalenza_ExternalMessages_Block_Adminhtml_Message_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Spalenza_ExternalMessages_Block_Adminhtml_Message_Grid constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId("messageGrid");
        $this->setDefaultSort("message_id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel("externalmessages/message")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn("message_id", array(
            "header" => Mage::helper("externalmessages")->__("ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "message_id",
        ));

        $this->addColumn("message", array(
            "header" => Mage::helper("externalmessages")->__("Message"),
            "index" => "message",
        ));

        $this->addColumn("recipient", array(
            "header" => Mage::helper("externalmessages")->__("Recipient"),
            "index" => "recipient",
        ));

        $this->addColumn("type", array(
            "header" => Mage::helper("externalmessages")->__("Type"),
            "index" => "type",
        ));

        $this->addColumn('created_at', array(
            'header' => Mage::helper('externalmessages')->__('Created At'),
            'index' => 'created_at',
            'type' => 'datetime',
        ));

        $this->addColumn('sent_at', array(
            'header' => Mage::helper('externalmessages')->__('Sent At'),
            'index' => 'sent_at',
            'type' => 'datetime',
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }

    /**
     * @param $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
    }

    /**
     * @return $this|Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('message_id');
        $this->getMassactionBlock()->setFormFieldName('message_ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('remove_message', array(
            'label' => Mage::helper('externalmessages')->__('Remove Message'),
            'url' => $this->getUrl('*/adminhtml_message/massRemove'),
            'confirm' => Mage::helper('externalmessages')->__('Are you sure?')
        ));

        return $this;
    }
}
