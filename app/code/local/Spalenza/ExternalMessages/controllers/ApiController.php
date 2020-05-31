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
 * Class Spalenza_ExternalMessages_ApiController
 */
class Spalenza_ExternalMessages_ApiController extends Mage_Core_Controller_Front_Action
{
    // Query string for limit
    const QUERY_LIMIT = 'limit';

    // Query string for pagination
    const QUERY_PAGE = 'page';

    // Max items per page
    const MAX_PER_PAGE = 100;

    /**
     * Retrieves the helper
     *
     * @return Spalenza_ExternalMessages_Helper_Data
     */
    public function getHelper($type = 'externalmessages')
    {
        return Mage::helper($type);
    }

    /**
     * Protected toJson response
     *
     * @param array $data
     * @param int $statusCode
     * @return Zend_Controller_Response_Abstract
     * @throws Zend_Controller_Response_Exception
     */
    protected function _toJson($data = array(), $statusCode = 200)
    {
        return $this
            ->getResponse()
            ->setHeader('Content-type', 'application/json')
            ->setBody(Zend_Json::encode($data))
            ->setHttpResponseCode($statusCode);
    }

    /**
     * Public toJson response
     *
     * @param array $data
     * @param int $statusCode
     * @return Zend_Controller_Response_Abstract
     * @throws Zend_Controller_Response_Exception
     */
    public function toJson($data = array(), $statusCode = 200)
    {
        return $this->_toJson($data, $statusCode);
    }

    /**
     * Validate basic authorization before dispatching
     */
    public function preDispatch()
    {
        parent::preDispatch();

        // Make sure to run if module is enabled and active on system config
        if (!$this->getHelper()->isModuleEnabled()) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true);
            return $this->toJson(array('message' => 'Module disabled'), 400);
        }

        // Validate basic authorization
        if (!$this->getHelper()->validateBasicAuth($this->getRequest())) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, true); // Comment this line for debugging purposes
            return $this->toJson(array('message' => 'Authentication failed'), 403);
        }

        return $this;
    }

    /**
     * @return int
     */
    protected function _getPageSize()
    {
        $pageSize = $this->getHelper()->getPageZize();

        if (is_numeric($pageSize) && (int) $pageSize > 0) {
            return (int) $pageSize;
        }

        return self::MAX_PER_PAGE;
    }

    /**
     * Prepares a generic collection
     * - It will prepare a DB collection with default accepted query string filters: limit, items per page and page number
     *
     * @param Varien_Data_Collection_Db $collection
     * @return bool|Varien_Data_Collection_Db
     * @throws Mage_Core_Model_Store_Exception
     */
    protected function _prepareCollection(Varien_Data_Collection_Db $collection)
    {
        $request = $this->getRequest();

        $columns = $collection->getColumnValues('store_id');
        $columns = array_filter(array_unique($columns));

        if (!empty($columns)) {
            $collection->addFieldToFilter('store_id', Mage::app()->getStore()->getStoreId());
        }

        $columns = null;
        $columns = $collection->getColumnValues('website_id');
        $columns = array_filter(array_unique($columns));

        if (!empty($columns)) {
            $collection->addFieldToFilter('website_id', Mage::app()->getStore()->getWebsiteId());
        }

        // Configure limit per page
        if ($request->has(self::QUERY_LIMIT)) {
            $limit = $request->get(self::QUERY_LIMIT);

            if ($limit > $this->_getPageSize()) {
                $limit = $this->_getPageSize();
            }
        } else {
            $limit = $this->_getPageSize();
        }

        $collection
            ->setPageSize($limit);

        // Configure pagination
        if ($request->has(self::QUERY_PAGE)) {
            $page = $request->get(self::QUERY_PAGE);
            $size = $collection->getLastPageNumber();
            if ($page > $size) {
                return false;
            }
        } else {
            $page = 1;
        }

        $collection->setCurPage($page);

        return $collection;
    }

    /**
     * Normalize a request params based on content-type and methods
     *
     * @param Zend_Controller_Request_Http $request Request with data (raw body, json, form data, etc)
     * @param array $methods Accepted methods to normalize data
     * @return Zend_Controller_Request_Http
     * @throws Zend_Controller_Request_Exception
     * @throws Zend_Json_Exception
     */
    protected function _normalizeParams(Zend_Controller_Request_Http $request, $methods = array('PUT', 'POST'))
    {
        if (in_array($request->getMethod(), $methods) && 'application/json' == $request->getHeader('Content-Type')) {
            if (false !== ($body = $request->getRawBody())) {
                if ($this->getHelper()->isDebug()) {
                    Mage::log($body, null, "debug-json.log");
                }

                try {
                    $body = str_replace("\t","",$body);
                    $body = str_replace("\r","",$body);
                    $body = str_replace("\n","",$body);
                    $data = Zend_Json::decode( $body );
                }
                catch (Exception $exception) {
                    Mage::logException($exception);
                    if ($this->getHelper()->isDebug()) {
                        Mage::log($body, null, "debug-json.log");
                    }
                    throw new Zend_Json_Exception($exception->getMessage());
                }

                $request->setParams($data);
            }
        }

        return $request;
    }

    /**
     * Messages Endpoint
     *
     * - GET retrieve messages
     * - POST create product
     */
    public function messagesAction()
    {
        $request = $this->_normalizeParams($this->getRequest());
        $errorMessages = array();

        // Operation: GET retrieve messages to send
        if ($request->isGet()) {
            try {

            } catch (\Exception $e) {
                Mage::logException($e);
                return $this->toJson(array('message' => 'Unable to retrieve messages (Internal Error)'), 500);
            }
        }

        // Operation: POST confirm that messages were sent
        if ($request->isPost()) {
            try {

            } catch (\Exception $e) {
                Mage::logException($e);
                return $this->toJson(array('message' => 'Unable to retrieve messages (Internal Error)'), 500);
            }
        }

        if (empty($errorMessages)) {
            $errorMessages[] = 'Invalid method for this endpoint';
        }

        return $this->toJson(array('message' => \implode(". ", $errorMessages)), (count($errorMessages) > 0) ? 400 : 200);
    }


}