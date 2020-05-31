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
 * Class Spalenza_ExternalMessages_Model_Sales_Order
 */
class Spalenza_ExternalMessages_Model_Sales_Order extends Mage_Sales_Model_Order
{
    /**
     * Order state protected setter.
     * By default allows to set any state. Can also update status to default or specified value
     * Сomplete and closed states are encapsulated intentionally, see the _checkState()
     *
     * @param string $state
     * @param bool $status
     * @param string $comment
     * @param null $isCustomerNotified
     * @param bool $shouldProtectState
     * @return $this|Mage_Sales_Model_Order
     * @throws Mage_Core_Exception
     */
    protected function _setState($state, $status = false, $comment = '',
                                 $isCustomerNotified = null, $shouldProtectState = false)
    {
        /** @var Spalenza_ExternalMessages_Helper_Data $helper */
        $helper = Mage::helper('externalmessages');

        if ($helper->isModuleEnabled() && $helper->isDebug()) {
            Mage::log('_setState: ' . $state . ' - ' . $status, null, 'change_status.log');
        }

        // attempt to set the specified state
        if ($shouldProtectState) {
            if ($this->isStateProtected($state)) {
                Mage::throwException(
                    Mage::helper('sales')->__('The Order State "%s" must not be set manually.', $state)
                );
            }
        }

        if ($helper->isModuleEnabled()) {
            $stateBefore = $this->getState();
            $statusBefore = $this->getStatus();

            // dispatch an event before we attempt to do anything
            Mage::dispatchEvent('sales_order_status_before',
                array(
                    'order' => $this,
                    'state' => $state,
                    'status' => $status,
                    'state_before' => $stateBefore,
                    'status_before' => $statusBefore,
                    'comment' => $comment,
                    'isCustomerNotified' => $isCustomerNotified,
                    'shouldProtectState' => $shouldProtectState
                )
            );
        }

        $this->setData('state', $state);
        // add status history
        if ($status) {
            if ($status === true) {
                $status = $this->getConfig()->getStateDefaultStatus($state);
            }
            $this->setStatus($status);
            $history = $this->addStatusHistoryComment($comment, false); // no sense to set $status again
            $history->setIsCustomerNotified($isCustomerNotified); // for backwards compatibility
        }

        if ($helper->isModuleEnabled()) {
            // dispatch an event after status has changed
            Mage::dispatchEvent('sales_order_status_after',
                array(
                    'order' => $this,
                    'state' => $state,
                    'status' => $status,
                    'state_before' => $stateBefore,
                    'status_before' => $statusBefore,
                    'comment' => $comment,
                    'isCustomerNotified' => $isCustomerNotified,
                    'shouldProtectState' => $shouldProtectState
                )
            );
        }

        return $this;
    }
}