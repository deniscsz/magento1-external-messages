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
 * Class Spalenza_ExternalMessages_Model_Observer
 */
class Spalenza_ExternalMessages_Model_Observer
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function orderStatusChanging(Varien_Event_Observer $observer)
    {
        /** @var Spalenza_ExternalMessages_Helper_Processor $helperProcessor */
        $helperProcessor = Mage::helper('externalmessages/processor');

        /** @var Mage_Sales_Model_Order $order */
        $order = $observer->getEvent()->getOrder();

        $helperProcessor->processOrderStatusChanging($order);
    }
}
