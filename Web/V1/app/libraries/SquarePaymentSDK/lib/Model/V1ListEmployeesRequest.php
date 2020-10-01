<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * V1ListEmployeesRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class V1ListEmployeesRequest implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'order' => 'string',
        'begin_updated_at' => 'string',
        'end_updated_at' => 'string',
        'begin_created_at' => 'string',
        'end_created_at' => 'string',
        'status' => 'string',
        'external_id' => 'string',
        'limit' => 'int',
        'batch_token' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'order' => 'order',
        'begin_updated_at' => 'begin_updated_at',
        'end_updated_at' => 'end_updated_at',
        'begin_created_at' => 'begin_created_at',
        'end_created_at' => 'end_created_at',
        'status' => 'status',
        'external_id' => 'external_id',
        'limit' => 'limit',
        'batch_token' => 'batch_token'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'order' => 'setOrder',
        'begin_updated_at' => 'setBeginUpdatedAt',
        'end_updated_at' => 'setEndUpdatedAt',
        'begin_created_at' => 'setBeginCreatedAt',
        'end_created_at' => 'setEndCreatedAt',
        'status' => 'setStatus',
        'external_id' => 'setExternalId',
        'limit' => 'setLimit',
        'batch_token' => 'setBatchToken'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'order' => 'getOrder',
        'begin_updated_at' => 'getBeginUpdatedAt',
        'end_updated_at' => 'getEndUpdatedAt',
        'begin_created_at' => 'getBeginCreatedAt',
        'end_created_at' => 'getEndCreatedAt',
        'status' => 'getStatus',
        'external_id' => 'getExternalId',
        'limit' => 'getLimit',
        'batch_token' => 'getBatchToken'
    );
  
    /**
      * $order The order in which employees are listed in the response, based on their created_at field.      Default value: ASC See [SortOrder](#type-sortorder) for possible values
      * @var string
      */
    protected $order;
    /**
      * $begin_updated_at If filtering results by their updated_at field, the beginning of the requested reporting period, in ISO 8601 format
      * @var string
      */
    protected $begin_updated_at;
    /**
      * $end_updated_at If filtering results by there updated_at field, the end of the requested reporting period, in ISO 8601 format.
      * @var string
      */
    protected $end_updated_at;
    /**
      * $begin_created_at If filtering results by their created_at field, the beginning of the requested reporting period, in ISO 8601 format.
      * @var string
      */
    protected $begin_created_at;
    /**
      * $end_created_at If filtering results by their created_at field, the end of the requested reporting period, in ISO 8601 format.
      * @var string
      */
    protected $end_created_at;
    /**
      * $status If provided, the endpoint returns only employee entities with the specified status (ACTIVE or INACTIVE). See [V1ListEmployeesRequestStatus](#type-v1listemployeesrequeststatus) for possible values
      * @var string
      */
    protected $status;
    /**
      * $external_id If provided, the endpoint returns only employee entities with the specified external_id.
      * @var string
      */
    protected $external_id;
    /**
      * $limit The maximum integer number of employee entities to return in a single response. Default 100, maximum 200.
      * @var int
      */
    protected $limit;
    /**
      * $batch_token A pagination cursor to retrieve the next set of results for your original query to the endpoint.
      * @var string
      */
    protected $batch_token;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["order"])) {
              $this->order = $data["order"];
            } else {
              $this->order = null;
            }
            if (isset($data["begin_updated_at"])) {
              $this->begin_updated_at = $data["begin_updated_at"];
            } else {
              $this->begin_updated_at = null;
            }
            if (isset($data["end_updated_at"])) {
              $this->end_updated_at = $data["end_updated_at"];
            } else {
              $this->end_updated_at = null;
            }
            if (isset($data["begin_created_at"])) {
              $this->begin_created_at = $data["begin_created_at"];
            } else {
              $this->begin_created_at = null;
            }
            if (isset($data["end_created_at"])) {
              $this->end_created_at = $data["end_created_at"];
            } else {
              $this->end_created_at = null;
            }
            if (isset($data["status"])) {
              $this->status = $data["status"];
            } else {
              $this->status = null;
            }
            if (isset($data["external_id"])) {
              $this->external_id = $data["external_id"];
            } else {
              $this->external_id = null;
            }
            if (isset($data["limit"])) {
              $this->limit = $data["limit"];
            } else {
              $this->limit = null;
            }
            if (isset($data["batch_token"])) {
              $this->batch_token = $data["batch_token"];
            } else {
              $this->batch_token = null;
            }
        }
    }
    /**
     * Gets order
     * @return string
     */
    public function getOrder()
    {
        return $this->order;
    }
  
    /**
     * Sets order
     * @param string $order The order in which employees are listed in the response, based on their created_at field.      Default value: ASC See [SortOrder](#type-sortorder) for possible values
     * @return $this
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }
    /**
     * Gets begin_updated_at
     * @return string
     */
    public function getBeginUpdatedAt()
    {
        return $this->begin_updated_at;
    }
  
    /**
     * Sets begin_updated_at
     * @param string $begin_updated_at If filtering results by their updated_at field, the beginning of the requested reporting period, in ISO 8601 format
     * @return $this
     */
    public function setBeginUpdatedAt($begin_updated_at)
    {
        $this->begin_updated_at = $begin_updated_at;
        return $this;
    }
    /**
     * Gets end_updated_at
     * @return string
     */
    public function getEndUpdatedAt()
    {
        return $this->end_updated_at;
    }
  
    /**
     * Sets end_updated_at
     * @param string $end_updated_at If filtering results by there updated_at field, the end of the requested reporting period, in ISO 8601 format.
     * @return $this
     */
    public function setEndUpdatedAt($end_updated_at)
    {
        $this->end_updated_at = $end_updated_at;
        return $this;
    }
    /**
     * Gets begin_created_at
     * @return string
     */
    public function getBeginCreatedAt()
    {
        return $this->begin_created_at;
    }
  
    /**
     * Sets begin_created_at
     * @param string $begin_created_at If filtering results by their created_at field, the beginning of the requested reporting period, in ISO 8601 format.
     * @return $this
     */
    public function setBeginCreatedAt($begin_created_at)
    {
        $this->begin_created_at = $begin_created_at;
        return $this;
    }
    /**
     * Gets end_created_at
     * @return string
     */
    public function getEndCreatedAt()
    {
        return $this->end_created_at;
    }
  
    /**
     * Sets end_created_at
     * @param string $end_created_at If filtering results by their created_at field, the end of the requested reporting period, in ISO 8601 format.
     * @return $this
     */
    public function setEndCreatedAt($end_created_at)
    {
        $this->end_created_at = $end_created_at;
        return $this;
    }
    /**
     * Gets status
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
  
    /**
     * Sets status
     * @param string $status If provided, the endpoint returns only employee entities with the specified status (ACTIVE or INACTIVE). See [V1ListEmployeesRequestStatus](#type-v1listemployeesrequeststatus) for possible values
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
    /**
     * Gets external_id
     * @return string
     */
    public function getExternalId()
    {
        return $this->external_id;
    }
  
    /**
     * Sets external_id
     * @param string $external_id If provided, the endpoint returns only employee entities with the specified external_id.
     * @return $this
     */
    public function setExternalId($external_id)
    {
        $this->external_id = $external_id;
        return $this;
    }
    /**
     * Gets limit
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }
  
    /**
     * Sets limit
     * @param int $limit The maximum integer number of employee entities to return in a single response. Default 100, maximum 200.
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }
    /**
     * Gets batch_token
     * @return string
     */
    public function getBatchToken()
    {
        return $this->batch_token;
    }
  
    /**
     * Sets batch_token
     * @param string $batch_token A pagination cursor to retrieve the next set of results for your original query to the endpoint.
     * @return $this
     */
    public function setBatchToken($batch_token)
    {
        $this->batch_token = $batch_token;
        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     * @param  integer $offset Offset 
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->$offset);
    }
  
    /**
     * Gets offset.
     * @param  integer $offset Offset 
     * @return mixed 
     */
    public function offsetGet($offset)
    {
        return $this->$offset;
    }
  
    /**
     * Sets value based on offset.
     * @param  integer $offset Offset 
     * @param  mixed   $value  Value to be set
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->$offset = $value;
    }
  
    /**
     * Unsets offset.
     * @param  integer $offset Offset 
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->$offset);
    }
  
    /**
     * Gets the string presentation of the object
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this), JSON_PRETTY_PRINT);
        } else {
            return json_encode(\SquareConnect\ObjectSerializer::sanitizeForSerialization($this));
        }
    }
}
