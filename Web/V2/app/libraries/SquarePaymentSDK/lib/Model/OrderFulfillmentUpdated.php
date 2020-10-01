<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * OrderFulfillmentUpdated Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 * Note: This endpoint is in beta.
 */
class OrderFulfillmentUpdated implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'order_id' => 'string',
        'version' => 'int',
        'location_id' => 'string',
        'state' => 'string',
        'created_at' => 'string',
        'updated_at' => 'string',
        'fulfillment_update' => '\SquareConnect\Model\OrderFulfillmentUpdatedUpdate[]'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'order_id' => 'order_id',
        'version' => 'version',
        'location_id' => 'location_id',
        'state' => 'state',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at',
        'fulfillment_update' => 'fulfillment_update'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'order_id' => 'setOrderId',
        'version' => 'setVersion',
        'location_id' => 'setLocationId',
        'state' => 'setState',
        'created_at' => 'setCreatedAt',
        'updated_at' => 'setUpdatedAt',
        'fulfillment_update' => 'setFulfillmentUpdate'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'order_id' => 'getOrderId',
        'version' => 'getVersion',
        'location_id' => 'getLocationId',
        'state' => 'getState',
        'created_at' => 'getCreatedAt',
        'updated_at' => 'getUpdatedAt',
        'fulfillment_update' => 'getFulfillmentUpdate'
    );
  
    /**
      * $order_id The order's unique ID.
      * @var string
      */
    protected $order_id;
    /**
      * $version Version number which is incremented each time an update is committed to the order. Orders that were not created through the API will not include a version and thus cannot be updated.  [Read more about working with versions](https://developer.squareup.com/docs/docs/orders-api/manage-orders#update-orders)
      * @var int
      */
    protected $version;
    /**
      * $location_id The ID of the merchant location this order is associated with.
      * @var string
      */
    protected $location_id;
    /**
      * $state The state of the order. See [OrderState](#type-orderstate) for possible values
      * @var string
      */
    protected $state;
    /**
      * $created_at Timestamp for when the order was created in RFC 3339 format.
      * @var string
      */
    protected $created_at;
    /**
      * $updated_at Timestamp for when the order was last updated in RFC 3339 format.
      * @var string
      */
    protected $updated_at;
    /**
      * $fulfillment_update The fulfillments that were updated with this version change.
      * @var \SquareConnect\Model\OrderFulfillmentUpdatedUpdate[]
      */
    protected $fulfillment_update;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["order_id"])) {
              $this->order_id = $data["order_id"];
            } else {
              $this->order_id = null;
            }
            if (isset($data["version"])) {
              $this->version = $data["version"];
            } else {
              $this->version = null;
            }
            if (isset($data["location_id"])) {
              $this->location_id = $data["location_id"];
            } else {
              $this->location_id = null;
            }
            if (isset($data["state"])) {
              $this->state = $data["state"];
            } else {
              $this->state = null;
            }
            if (isset($data["created_at"])) {
              $this->created_at = $data["created_at"];
            } else {
              $this->created_at = null;
            }
            if (isset($data["updated_at"])) {
              $this->updated_at = $data["updated_at"];
            } else {
              $this->updated_at = null;
            }
            if (isset($data["fulfillment_update"])) {
              $this->fulfillment_update = $data["fulfillment_update"];
            } else {
              $this->fulfillment_update = null;
            }
        }
    }
    /**
     * Gets order_id
     * @return string
     */
    public function getOrderId()
    {
        return $this->order_id;
    }
  
    /**
     * Sets order_id
     * @param string $order_id The order's unique ID.
     * @return $this
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
        return $this;
    }
    /**
     * Gets version
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }
  
    /**
     * Sets version
     * @param int $version Version number which is incremented each time an update is committed to the order. Orders that were not created through the API will not include a version and thus cannot be updated.  [Read more about working with versions](https://developer.squareup.com/docs/docs/orders-api/manage-orders#update-orders)
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
        return $this;
    }
    /**
     * Gets location_id
     * @return string
     */
    public function getLocationId()
    {
        return $this->location_id;
    }
  
    /**
     * Sets location_id
     * @param string $location_id The ID of the merchant location this order is associated with.
     * @return $this
     */
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
        return $this;
    }
    /**
     * Gets state
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
  
    /**
     * Sets state
     * @param string $state The state of the order. See [OrderState](#type-orderstate) for possible values
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }
    /**
     * Gets created_at
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
  
    /**
     * Sets created_at
     * @param string $created_at Timestamp for when the order was created in RFC 3339 format.
     * @return $this
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }
    /**
     * Gets updated_at
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
  
    /**
     * Sets updated_at
     * @param string $updated_at Timestamp for when the order was last updated in RFC 3339 format.
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }
    /**
     * Gets fulfillment_update
     * @return \SquareConnect\Model\OrderFulfillmentUpdatedUpdate[]
     */
    public function getFulfillmentUpdate()
    {
        return $this->fulfillment_update;
    }
  
    /**
     * Sets fulfillment_update
     * @param \SquareConnect\Model\OrderFulfillmentUpdatedUpdate[] $fulfillment_update The fulfillments that were updated with this version change.
     * @return $this
     */
    public function setFulfillmentUpdate($fulfillment_update)
    {
        $this->fulfillment_update = $fulfillment_update;
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
