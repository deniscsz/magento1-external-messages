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
 * Class Spalenza_ExternalMessages_Helper_Processor
 */
class Spalenza_ExternalMessages_Helper_Processor extends Spalenza_ExternalMessages_Helper_Data
{
    /**
     * @param $template
     * @param array $variables
     * @return string
     */
    public function itemTemplateProcessor($template, $variables = array())
    {
        $helper = Mage::helper('cms');
        return $helper->getPageTemplateProcessor()->setVariables($variables)->filter($template);
    }

    /**
     * Use values as variables to messages
     * @param $object
     * @return array
     */
    public function getVariables($object)
    {
        if (!empty($object)) {
            if ($object instanceof Varien_Object) {
                return $object->getData();
            } elseif(is_array($object)) {
                return $object;
            }
        }

        return [];
    }

    /**
     * @param $object
     * @return string
     */
    public function getRecipient($object)
    {
        if (!empty($object)) {
            if ($object instanceof Mage_Sales_Model_Order) {
                $telephone = $object->getShippingAddress()->getTelephone();
                if (!$telephone) {
                    $telephone = $object->getShippingAddress()->getFax();
                }
                return $telephone;
            }
        }

        return '';
    }

    /**
     * @param $data
     * @return false|Mage_Core_Model_Abstract|string
     */
    public function createNewMessage($data)
    {
        try {
            $model = Mage::getModel('externalmessages/message');
            $model->setData($data);
            $model->save();
            return $model;
        } catch (\Exception $e) {
            Mage::logException($e);
            return $e->getMessage();
        }
    }

    /**
     * @param $object
     * @param $templates
     * @return bool
     */
    public function generateMessagesFromTemplate($object, $templates)
    {
        /** @var array $variables */
        $variables = $this->getVariables($object);

        /** @var Spalenza_ExternalMessages_Model_Template $template */
        foreach ($templates as $template) {
            $content = $template->getData('content');
            $contentProcessed = $this->itemTemplateProcessor($content, $variables);

            $data = [
                'recipient' => $this->getRecipient($object),
                'message' => $contentProcessed,
                'type' => $template->getData('rule')
            ];

            $message = $this->createNewMessage($data);

            if (false == is_object($message)) {
                if ($this->isDebug()) {
                    Mage::log('External Message extension error: ' . $message);
                }
                return false;
            }
        }

        return true;
    }

    /**
     * Get valid templates
     * @param null|string $rule
     * @return Spalenza_ExternalMessages_Model_Mysql4_Template_Collection
     */
    public function getValidTemplates($rule = null)
    {
        /** @var Spalenza_ExternalMessages_Model_Mysql4_Template_Collection $templates */
        $templates = Mage::getModel('externalmessages/template')->getCollection();
        $templates->addFieldToFilter('status', array('eq' => 1));

        if ($rule) {
            $templates->addFieldToFilter('rule', array('eq' => $rule));
        }

        return $templates;
    }

    /**
     * @param $order
     * @return bool
     */
    public function processOrderStatusChanging($order)
    {
        $templates = $this->getValidTemplates(self::RULE_STATUS_CHANGES);

        if ($templates->getSize()) {
            return $this->generateMessagesFromTemplate($order, $templates);
        }

        return false;
    }
}