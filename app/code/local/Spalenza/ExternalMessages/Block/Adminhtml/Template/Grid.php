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
 * Class Spalenza_ExternalMessages_Block_Adminhtml_Template_Grid
 */
class Spalenza_ExternalMessages_Block_Adminhtml_Template_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Spalenza_ExternalMessages_Block_Adminhtml_Template_Grid constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setId("templateGrid");
        $this->setDefaultSort("template_id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel("externalmessages/template")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn("template_id", array(
            "header" => Mage::helper("externalmessages")->__("ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "template_id",
        ));

        $this->addColumn("title", array(
            "header" => Mage::helper("externalmessages")->__("Title"),
            "index" => "title",
        ));
        $this->addColumn("content", array(
            "header" => Mage::helper("externalmessages")->__("Message"),
            "index" => "content",
        ));
        $this->addColumn('status', array(
            'header' => Mage::helper('externalmessages')->__('Enabled'),
            'index' => 'status',
            'type' => 'options',
            'options'    => array(
                1 => Mage::helper('catalog')->__('Enabled'),
                0 => Mage::helper('catalog')->__('Disabled')
            )
        ));

        $this->addColumn('rule', array(
            'header' => Mage::helper('externalmessages')->__('Rule'),
            'index' => 'rule',
            'type' => 'options',
            'options' => Spalenza_ExternalMessages_Block_Adminhtml_Template_Grid::getOptionRules(),
        ));

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
        $this->setMassactionIdField('template_id');
        $this->getMassactionBlock()->setFormFieldName('template_ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('remove_template', array(
            'label' => Mage::helper('externalmessages')->__('Remove Template'),
            'url' => $this->getUrl('*/adminhtml_template/massRemove'),
            'confirm' => Mage::helper('externalmessages')->__('Are you sure?')
        ));
        return $this;
    }

    /**
     * @return array
     */
    static public function getOptionStatus()
    {
        $data_array = array();
        $data_array[0] = Mage::helper('externalmessages')->__('Disabled');
        $data_array[1] = Mage::helper('externalmessages')->__('Enabled');
        return ($data_array);
    }

    /**
     * @return array
     */
    static public function getValueStatus()
    {
        $data_array = array();
        foreach (Spalenza_ExternalMessages_Block_Adminhtml_Template_Grid::getOptionStatus() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return ($data_array);
    }

    static public function getOptionRules()
    {
        $data_array = array();
        $data_array[0] = Mage::helper('externalmessages')->__('Rule 1');
        $data_array[1] = Mage::helper('externalmessages')->__('Rule 2');
        return ($data_array);
    }

    static public function getValueRules()
    {
        $data_array = array();
        foreach (Spalenza_ExternalMessages_Block_Adminhtml_Template_Grid::getOptionRules() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return ($data_array);

    }
}
