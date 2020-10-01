<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * InventoryCount Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class InventoryCount implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'catalog_object_id' => 'string',
        'catalog_object_type' => 'string',
        'state' => 'string',
        'location_id' => 'string',
        'quantity' => 'string',
        'calculated_at' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'catalog_object_id' => 'catalog_object_id',
        'catalog_object_type' => 'catalog_object_type',
        'state' => 'state',
        'location_id' => 'location_id',
        'quantity' => 'quantity',
        'calculated_at' => 'calculated_at'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'catalog_object_id' => 'setCatalogObjectId',
        'catalog_object_type' => 'setCatalogObjectType',
        'state' => 'setState',
        'location_id' => 'setLocationId',
        'quantity' => 'setQuantity',
        'calculated_at' => 'setCalculatedAt'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'catalog_object_id' => 'getCatalogObjectId',
        'catalog_object_type' => 'getCatalogObjectType',
        'state' => 'getState',
        'location_id' => 'getLocationId',
        'quantity' => 'getQuantity',
        'calculated_at' => 'getCalculatedAt'
    );
  
    /**
      * $catalog_object_id The Square generated ID of the `CatalogObject` being tracked.
      * @var string
      */
    protected $catalog_object_id;
    /**
      * $catalog_object_type The `CatalogObjectType` of the `CatalogObject` being tracked. Tracking is only supported for the `ITEM_VARIATION` type.
      * @var string
      */
    protected $catalog_object_type;
    /**
      * $state The current `InventoryState` for the related quantity of items. See [InventoryState](#type-inventorystate) for possible values
      * @var string
      */
    protected $state;
    /**
      * $location_id The Square ID of the `Location` where the related quantity of items are being tracked.
      * @var string
      */
    protected $location_id;
    /**
      * $quantity The number of items affected by the estimated count as a decimal string. Can support up to 5 digits after the decimal point.  _Important_: The Point of Sale app and Dashboard do not currently support decimal quantities. If a Point of Sale app or Dashboard attempts to read a decimal quantity on inventory counts or adjustments, the quantity will be rounded down to the nearest integer. For example, `2.5` will become `2`, and `-2.5` will become `-3`. Read [Decimal Quantities (BETA)](https://developer.squareup.com/docs/docs/inventory-api/what-it-does#decimal-quantities-beta) for more information.
      * @var string
      */
    protected $quantity;
    /**
      * $calculated_at A read-only timestamp in RFC 3339 format that indicates when Square received the most recent physical count or adjustment that had an affect on the estimated count.
      * @var string
      */
    protected $calculated_at;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["catalog_object_id"])) {
              $this->catalog_object_id = $data["catalog_object_id"];
            } else {
              $this->catalog_object_id = null;
            }
            if (isset($data["catalog_object_type"])) {
              $this->catalog_object_type = $data["catalog_object_type"];
            } else {
              $this->catalog_object_type = null;
            }
            if (isset($data["state"])) {
              $this->state = $data["state"];
            } else {
              $this->state = null;
            }
            if (isset($data["location_id"])) {
              $this->location_id = $data["location_id"];
            } else {
              $this->location_id = null;
            }
            if (isset($data["quantity"])) {
              $this->quantity = $data["quantity"];
            } else {
              $this->quantity = null;
            }
            if (isset($data["calculated_at"])) {
              $this->calculated_at = $data["calculated_at"];
            } else {
              $this->calculated_at = null;
            }
        }
    }
    /**
     * Gets catalog_object_id
     * @return string
     */
    public function getCatalogObjectId()
    {
        return $this->catalog_object_id;
    }
  
    /**
     * Sets catalog_object_id
     * @param string $catalog_object_id The Square generated ID of the `CatalogObject` being tracked.
     * @return $this
     */
    public function setCatalogObjectId($catalog_object_id)
    {
        $this->catalog_object_id = $catalog_object_id;
        return $this;
    }
    /**
     * Gets catalog_object_type
     * @return string
     */
    public function getCatalogObjectType()
    {
        return $this->catalog_object_type;
    }
  
    /**
     * Sets catalog_object_type
     * @param string $catalog_object_type The `CatalogObjectType` of the `CatalogObject` being tracked. Tracking is only supported for the `ITEM_VARIATION` type.
     * @return $this
     */
    public function setCatalogObjectType($catalog_object_type)
    {
        $this->catalog_object_type = $catalog_object_type;
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
     * @param string $state The current `InventoryState` for the related quantity of items. See [InventoryState](#type-inventorystate) for possible values
     * @return $this
     */
    public function setState($state)
    {
        $this->state = $state;
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
     * @param string $location_id The Square ID of the `Location` where the related quantity of items are being tracked.
     * @return $this
     */
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
        return $this;
    }
    /**
     * Gets quantity
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
  
    /**
     * Sets quantity
     * @param string $quantity The number of items affected by the estimated count as a decimal string. Can support up to 5 digits after the decimal point.  _Important_: The Point of Sale app and Dashboard do not currently support decimal quantities. If a Point of Sale app or Dashboard attempts to read a decimal quantity on inventory counts or adjustments, the quantity will be rounded down to the nearest integer. For example, `2.5` will become `2`, and `-2.5` will become `-3`. Read [Decimal Quantities (BETA)](https://developer.squareup.com/docs/docs/inventory-api/what-it-does#decimal-quantities-beta) for more information.
     * @return $this
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }
    /**
     * Gets calculated_at
     * @return string
     */
    public function getCalculatedAt()
    {
        return $this->calculated_at;
    }
  
    /**
     * Sets calculated_at
     * @param string $calculated_at A read-only timestamp in RFC 3339 format that indicates when Square received the most recent physical count or adjustment that had an affect on the estimated count.
     * @return $this
     */
    public function setCalculatedAt($calculated_at)
    {
        $this->calculated_at = $calculated_at;
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