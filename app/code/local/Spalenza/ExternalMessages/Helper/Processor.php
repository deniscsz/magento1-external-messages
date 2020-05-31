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
     * @return array|mixed
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
}