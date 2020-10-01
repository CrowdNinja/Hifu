<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program. 
 * https://github.com/swagger-api/swagger-codegen 
 * Do not edit the class manually.
 */

namespace SquareConnect\Api;

use \SquareConnect\Configuration;
use \SquareConnect\ApiClient;
use \SquareConnect\ApiException;
use \SquareConnect\ObjectSerializer;

/**
 * OrdersApi Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache Licene v2
 * @link     https://squareup.com/developers
 */
class OrdersApi
{

    /**
     * API Client
     * @var \SquareConnect\ApiClient instance of the ApiClient
     */
    protected $apiClient;
  
    /**
     * Constructor
     * @param \SquareConnect\ApiClient|null $apiClient The api client to use
     */
    function __construct($apiClient = null)
    {
        if ($apiClient == null) {
            $apiClient = new ApiClient();
            $apiClient->getConfig()->setHost('https://connect.squareup.com');
        }
  
        $this->apiClient = $apiClient;
    }
  
    /**
     * Get API client
     * @return \SquareConnect\ApiClient get the API client
     */
    public function getApiClient()
    {
        return $this->apiClient;
    }
  
    /**
     * Set the API client
     * @param \SquareConnect\ApiClient $apiClient set the API client
     * @return OrdersApi
     */
    public function setApiClient(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
        return $this;
    }
  
    /**
     * batchRetrieveOrders
     *
     * BatchRetrieveOrders
     *
     * @param string $location_id The ID of the orders&#39; associated location. (required)
     * @param \SquareConnect\Model\BatchRetrieveOrdersRequest $body An object containing the fields to POST for the request.  See the corresponding object definition for field details. (required)
     * @return \SquareConnect\Model\BatchRetrieveOrdersResponse
     * @throws \SquareConnect\ApiException on non-2xx response
     */
    public function batchRetrieveOrders($location_id, $body)
    {
        list($response, $statusCode, $httpHeader) = $this->batchRetrieveOrdersWithHttpInfo ($location_id, $body);
        return $response; 
    }


    /**
     * batchRetrieveOrdersWithHttpInfo
     *
     * BatchRetrieveOrders
     *
     * @param string $location_id The ID of the orders&#39; associated location. (required)
     * @param \SquareConnect\Model\BatchRetrieveOrdersRequest $body An object containing the fields to POST for the request.  See the corresponding object definition for field details. (required)
     * @return Array of \SquareConnect\Model\BatchRetrieveOrdersResponse, HTTP status code, HTTP response headers (array of strings)
     * @throws \SquareConnect\ApiException on non-2xx response
     */
    public function batchRetrieveOrdersWithHttpInfo($location_id, $body)
    {
        
        // verify the required parameter 'location_id' is set
        if ($location_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $location_id when calling batchRetrieveOrders');
        }
        // verify the required parameter 'body' is set
        if ($body === null) {
            throw new \InvalidArgumentException('Missing the required parameter $body when calling batchRetrieveOrders');
        }
  
        // parse inputs
        $resourcePath = "/v2/locations/{location_id}/orders/batch-retrieve";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = ApiClient::selectHeaderAccept(array('application/json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = ApiClient::selectHeaderContentType(array('application/json'));
        $headerParams['Square-Version'] = "2020-04-22";

        
        
        // path params
        if ($location_id !== null) {
            $resourcePath = str_replace(
                "{" . "location_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($location_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // body params
        $_tempBody = null;
        if (isset($body)) {
            $_tempBody = $body;
        }
  
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath, 'POST',
                $queryParams, $httpBody,
                $headerParams, '\SquareConnect\Model\BatchRetrieveOrdersResponse'
            );
            if (!$response) {
                return array(null, $statusCode, $httpHeader);
            }

            return array(\SquareConnect\ObjectSerializer::deserialize($response, '\SquareConnect\Model\BatchRetrieveOrdersResponse', $httpHeader), $statusCode, $httpHeader);
                    } catch (ApiException $e) {
            switch ($e->getCode()) { 
            case 200:
                $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), '\SquareConnect\Model\BatchRetrieveOrdersResponse', $e->getResponseHeaders());
                $e->setResponseObject($data);
                break;
            }
  
            throw $e;
        }
    }
    /**
     * createOrder
     *
     * CreateOrder
     *
     * @param string $location_id The ID of the business location to associate the order with. (required)
     * @param \SquareConnect\Model\CreateOrderRequest $body An object containing the fields to POST for the request.  See the corresponding object definition for field details. (required)
     * @return \SquareConnect\Model\CreateOrderResponse
     * @throws \SquareConnect\ApiException on non-2xx response
     */
    public function createOrder($location_id, $body)
    {
        list($response, $statusCode, $httpHeader) = $this->createOrderWithHttpInfo ($location_id, $body);
        return $response; 
    }


    /**
     * createOrderWithHttpInfo
     *
     * CreateOrder
     *
     * @param string $location_id The ID of the business location to associate the order with. (required)
     * @param \SquareConnect\Model\CreateOrderRequest $body An object containing the fields to POST for the request.  See the corresponding object definition for field details. (required)
     * @return Array of \SquareConnect\Model\CreateOrderResponse, HTTP status code, HTTP response headers (array of strings)
     * @throws \SquareConnect\ApiException on non-2xx response
     */
    public function createOrderWithHttpInfo($location_id, $body)
    {
        
        // verify the required parameter 'location_id' is set
        if ($location_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $location_id when calling createOrder');
        }
        // verify the required parameter 'body' is set
        if ($body === null) {
            throw new \InvalidArgumentException('Missing the required parameter $body when calling createOrder');
        }
  
        // parse inputs
        $resourcePath = "/v2/locations/{location_id}/orders";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = ApiClient::selectHeaderAccept(array('application/json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = ApiClient::selectHeaderContentType(array('application/json'));
        $headerParams['Square-Version'] = "2020-04-22";

        
        
        // path params
        if ($location_id !== null) {
            $resourcePath = str_replace(
                "{" . "location_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($location_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // body params
        $_tempBody = null;
        if (isset($body)) {
            $_tempBody = $body;
        }
  
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath, 'POST',
                $queryParams, $httpBody,
                $headerParams, '\SquareConnect\Model\CreateOrderResponse'
            );
            if (!$response) {
                return array(null, $statusCode, $httpHeader);
            }

            return array(\SquareConnect\ObjectSerializer::deserialize($response, '\SquareConnect\Model\CreateOrderResponse', $httpHeader), $statusCode, $httpHeader);
                    } catch (ApiException $e) {
            switch ($e->getCode()) { 
            case 200:
                $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), '\SquareConnect\Model\CreateOrderResponse', $e->getResponseHeaders());
                $e->setResponseObject($data);
                break;
            }
  
            throw $e;
        }
    }
    /**
     * payOrder
     *
     * PayOrder
     * Note: This endpoint is in beta.
     *
     * @param string $order_id The ID of the order being paid. (required)
     * @param \SquareConnect\Model\PayOrderRequest $body An object containing the fields to POST for the request.  See the corresponding object definition for field details. (required)
     * @return \SquareConnect\Model\PayOrderResponse
     * @throws \SquareConnect\ApiException on non-2xx response
     */
    public function payOrder($order_id, $body)
    {
        list($response, $statusCode, $httpHeader) = $this->payOrderWithHttpInfo ($order_id, $body);
        return $response; 
    }


    /**
     * payOrderWithHttpInfo
     *
     * PayOrder
     *
     * @param string $order_id The ID of the order being paid. (required)
     * @param \SquareConnect\Model\PayOrderRequest $body An object containing the fields to POST for the request.  See the corresponding object definition for field details. (required)
     * @return Array of \SquareConnect\Model\PayOrderResponse, HTTP status code, HTTP response headers (array of strings)
     * @throws \SquareConnect\ApiException on non-2xx response
     */
    public function payOrderWithHttpInfo($order_id, $body)
    {
        
        // verify the required parameter 'order_id' is set
        if ($order_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $order_id when calling payOrder');
        }
        // verify the required parameter 'body' is set
        if ($body === null) {
            throw new \InvalidArgumentException('Missing the required parameter $body when calling payOrder');
        }
  
        // parse inputs
        $resourcePath = "/v2/orders/{order_id}/pay";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = ApiClient::selectHeaderAccept(array('application/json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = ApiClient::selectHeaderContentType(array('application/json'));
        $headerParams['Square-Version'] = "2020-04-22";

        
        
        // path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                "{" . "order_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($order_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // body params
        $_tempBody = null;
        if (isset($body)) {
            $_tempBody = $body;
        }
  
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath, 'POST',
                $queryParams, $httpBody,
                $headerParams, '\SquareConnect\Model\PayOrderResponse'
            );
            if (!$response) {
                return array(null, $statusCode, $httpHeader);
            }

            return array(\SquareConnect\ObjectSerializer::deserialize($response, '\SquareConnect\Model\PayOrderResponse', $httpHeader), $statusCode, $httpHeader);
                    } catch (ApiException $e) {
            switch ($e->getCode()) { 
            case 200:
                $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), '\SquareConnect\Model\PayOrderResponse', $e->getResponseHeaders());
                $e->setResponseObject($data);
                break;
            }
  
            throw $e;
        }
    }
    /**
     * searchOrders
     *
     * SearchOrders
     *
     * @param \SquareConnect\Model\SearchOrdersRequest $body An object containing the fields to POST for the request.  See the corresponding object definition for field details. (required)
     * @return \SquareConnect\Model\SearchOrdersResponse
     * @throws \SquareConnect\ApiException on non-2xx response
     */
    public function searchOrders($body)
    {
        list($response, $statusCode, $httpHeader) = $this->searchOrdersWithHttpInfo ($body);
        return $response; 
    }


    /**
     * searchOrdersWithHttpInfo
     *
     * SearchOrders
     *
     * @param \SquareConnect\Model\SearchOrdersRequest $body An object containing the fields to POST for the request.  See the corresponding object definition for field details. (required)
     * @return Array of \SquareConnect\Model\SearchOrdersResponse, HTTP status code, HTTP response headers (array of strings)
     * @throws \SquareConnect\ApiException on non-2xx response
     */
    public function searchOrdersWithHttpInfo($body)
    {
        
        // verify the required parameter 'body' is set
        if ($body === null) {
            throw new \InvalidArgumentException('Missing the required parameter $body when calling searchOrders');
        }
  
        // parse inputs
        $resourcePath = "/v2/orders/search";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = ApiClient::selectHeaderAccept(array('application/json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = ApiClient::selectHeaderContentType(array('application/json'));
        $headerParams['Square-Version'] = "2020-04-22";

        
        
        
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // body params
        $_tempBody = null;
        if (isset($body)) {
            $_tempBody = $body;
        }
  
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath, 'POST',
                $queryParams, $httpBody,
                $headerParams, '\SquareConnect\Model\SearchOrdersResponse'
            );
            if (!$response) {
                return array(null, $statusCode, $httpHeader);
            }

            return array(\SquareConnect\ObjectSerializer::deserialize($response, '\SquareConnect\Model\SearchOrdersResponse', $httpHeader), $statusCode, $httpHeader);
                    } catch (ApiException $e) {
            switch ($e->getCode()) { 
            case 200:
                $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), '\SquareConnect\Model\SearchOrdersResponse', $e->getResponseHeaders());
                $e->setResponseObject($data);
                break;
            }
  
            throw $e;
        }
    }
    /**
     * updateOrder
     *
     * UpdateOrder
     * Note: This endpoint is in beta.
     *
     * @param string $location_id The ID of the order&#39;s associated location. (required)
     * @param string $order_id The ID of the order to update. (required)
     * @param \SquareConnect\Model\UpdateOrderRequest $body An object containing the fields to POST for the request.  See the corresponding object definition for field details. (required)
     * @return \SquareConnect\Model\UpdateOrderResponse
     * @throws \SquareConnect\ApiException on non-2xx response
     */
    public function updateOrder($location_id, $order_id, $body)
    {
        list($response, $statusCode, $httpHeader) = $this->updateOrderWithHttpInfo ($location_id, $order_id, $body);
        return $response; 
    }


    /**
     * updateOrderWithHttpInfo
     *
     * UpdateOrder
     *
     * @param string $location_id The ID of the order&#39;s associated location. (required)
     * @param string $order_id The ID of the order to update. (required)
     * @param \SquareConnect\Model\UpdateOrderRequest $body An object containing the fields to POST for the request.  See the corresponding object definition for field details. (required)
     * @return Array of \SquareConnect\Model\UpdateOrderResponse, HTTP status code, HTTP response headers (array of strings)
     * @throws \SquareConnect\ApiException on non-2xx response
     */
    public function updateOrderWithHttpInfo($location_id, $order_id, $body)
    {
        
        // verify the required parameter 'location_id' is set
        if ($location_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $location_id when calling updateOrder');
        }
        // verify the required parameter 'order_id' is set
        if ($order_id === null) {
            throw new \InvalidArgumentException('Missing the required parameter $order_id when calling updateOrder');
        }
        // verify the required parameter 'body' is set
        if ($body === null) {
            throw new \InvalidArgumentException('Missing the required parameter $body when calling updateOrder');
        }
  
        // parse inputs
        $resourcePath = "/v2/locations/{location_id}/orders/{order_id}";
        $httpBody = '';
        $queryParams = array();
        $headerParams = array();
        $formParams = array();
        $_header_accept = ApiClient::selectHeaderAccept(array('application/json'));
        if (!is_null($_header_accept)) {
            $headerParams['Accept'] = $_header_accept;
        }
        $headerParams['Content-Type'] = ApiClient::selectHeaderContentType(array('application/json'));
        $headerParams['Square-Version'] = "2020-04-22";

        
        
        // path params
        if ($location_id !== null) {
            $resourcePath = str_replace(
                "{" . "location_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($location_id),
                $resourcePath
            );
        }// path params
        if ($order_id !== null) {
            $resourcePath = str_replace(
                "{" . "order_id" . "}",
                $this->apiClient->getSerializer()->toPathValue($order_id),
                $resourcePath
            );
        }
        // default format to json
        $resourcePath = str_replace("{format}", "json", $resourcePath);

        
        // body params
        $_tempBody = null;
        if (isset($body)) {
            $_tempBody = $body;
        }
  
        // for model (json/xml)
        if (isset($_tempBody)) {
            $httpBody = $_tempBody; // $_tempBody is the method argument, if present
        } elseif (count($formParams) > 0) {
            $httpBody = $formParams; // for HTTP post (form)
        }
        
        // this endpoint requires OAuth (access token)
        if (strlen($this->apiClient->getConfig()->getAccessToken()) !== 0) {
            $headerParams['Authorization'] = 'Bearer ' . $this->apiClient->getConfig()->getAccessToken();
        }
        // make the API Call
        try {
            list($response, $statusCode, $httpHeader) = $this->apiClient->callApi(
                $resourcePath, 'PUT',
                $queryParams, $httpBody,
                $headerParams, '\SquareConnect\Model\UpdateOrderResponse'
            );
            if (!$response) {
                return array(null, $statusCode, $httpHeader);
            }

            return array(\SquareConnect\ObjectSerializer::deserialize($response, '\SquareConnect\Model\UpdateOrderResponse', $httpHeader), $statusCode, $httpHeader);
                    } catch (ApiException $e) {
            switch ($e->getCode()) { 
            case 200:
                $data = \SquareConnect\ObjectSerializer::deserialize($e->getResponseBody(), '\SquareConnect\Model\UpdateOrderResponse', $e->getResponseHeaders());
                $e->setResponseObject($data);
                break;
            }
  
            throw $e;
        }
    }
}
