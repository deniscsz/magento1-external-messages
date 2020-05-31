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
 * Class Spalenza_ExternalMessages_Adminhtml_MessageController
 */
class Spalenza_ExternalMessages_Adminhtml_MessageController extends Mage_Adminhtml_Controller_Action
{
    protected function _isAllowed()
    {
        //return Mage::getSingleton('admin/session')->isAllowed('externalmessages/message');
        return true;
    }

    protected function _initAction()
    {
        $this->loadLayout()->_setActiveMenu("externalmessages/message")->_addBreadcrumb(Mage::helper("adminhtml")->__("Message  Manager"), Mage::helper("adminhtml")->__("Message Manager"));
        return $this;
    }

    public function indexAction()
    {
        $this->_title($this->__("ExternalMessages"));
        $this->_title($this->__("Manager Message"));

        $this->_initAction();
        $this->renderLayout();
    }

    public function editAction()
    {
        $this->_title($this->__("ExternalMessages"));
        $this->_title($this->__("Message"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("externalmessages/message")->load($id);
        if ($model->getId()) {
            Mage::register("message_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("externalmessages/message");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Message Manager"), Mage::helper("adminhtml")->__("Message Manager"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Message Description"), Mage::helper("adminhtml")->__("Message Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("externalmessages/adminhtml_message_edit"))->_addLeft($this->getLayout()->createBlock("externalmessages/adminhtml_message_edit_tabs"));
            $this->renderLayout();
        } else {
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("externalmessages")->__("Item does not exist."));
            $this->_redirect("*/*/");
        }
    }

    public function newAction()
    {

        $this->_title($this->__("ExternalMessages"));
        $this->_title($this->__("Message"));
        $this->_title($this->__("New Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("externalmessages/message")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("message_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("externalmessages/message");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Message Manager"), Mage::helper("adminhtml")->__("Message Manager"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Message Description"), Mage::helper("adminhtml")->__("Message Description"));


        $this->_addContent($this->getLayout()->createBlock("externalmessages/adminhtml_message_edit"))->_addLeft($this->getLayout()->createBlock("externalmessages/adminhtml_message_edit_tabs"));

        $this->renderLayout();

    }

    public function saveAction()
    {
        $post_data = $this->getRequest()->getPost();
        if ($post_data) {
            try {
                $model = Mage::getModel("externalmessages/message")
                    ->addData($post_data)
                    ->setId($this->getRequest()->getParam("id"))
                    ->save();

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Message was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setMessageData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setMessageData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }

        }
        $this->_redirect("*/*/");
    }


    public function deleteAction()
    {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("externalmessages/message");
                $model->setId($this->getRequest()->getParam("id"))->delete();
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
                $this->_redirect("*/*/");
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
            }
        }
        $this->_redirect("*/*/");
    }


    public function massRemoveAction()
    {
        try {
            $ids = $this->getRequest()->getPost('message_ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel("externalmessages/message");
                $model->setId($id)->delete();
            }
            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
        } catch (Exception $e) {
            Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction()
    {
        $fileName = 'message.csv';
        $grid = $this->getLayout()->createBlock('externalmessages/adminhtml_message_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction()
    {
        $fileName = 'message.xml';
        $grid = $this->getLayout()->createBlock('externalmessages/adminhtml_message_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }
}
