<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * ListCashDrawerShiftsRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class ListCashDrawerShiftsRequest implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'location_id' => 'string',
        'sort_order' => 'string',
        'begin_time' => 'string',
        'end_time' => 'string',
        'limit' => 'int',
        'cursor' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'location_id' => 'location_id',
        'sort_order' => 'sort_order',
        'begin_time' => 'begin_time',
        'end_time' => 'end_time',
        'limit' => 'limit',
        'cursor' => 'cursor'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'location_id' => 'setLocationId',
        'sort_order' => 'setSortOrder',
        'begin_time' => 'setBeginTime',
        'end_time' => 'setEndTime',
        'limit' => 'setLimit',
        'cursor' => 'setCursor'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'location_id' => 'getLocationId',
        'sort_order' => 'getSortOrder',
        'begin_time' => 'getBeginTime',
        'end_time' => 'getEndTime',
        'limit' => 'getLimit',
        'cursor' => 'getCursor'
    );
  
    /**
      * $location_id The ID of the location to query for a list of cash drawer shifts.
      * @var string
      */
    protected $location_id;
    /**
      * $sort_order The order in which cash drawer shifts are listed in the response, based on their opened_at field. Default value: ASC See [SortOrder](#type-sortorder) for possible values
      * @var string
      */
    protected $sort_order;
    /**
      * $begin_time The inclusive start time of the query on opened_at, in ISO 8601 format.
      * @var string
      */
    protected $begin_time;
    /**
      * $end_time The exclusive end date of the query on opened_at, in ISO 8601 format.
      * @var string
      */
    protected $end_time;
    /**
      * $limit Number of cash drawer shift events in a page of results (200 by default, 1000 max).
      * @var int
      */
    protected $limit;
    /**
      * $cursor Opaque cursor for fetching the next page of results.
      * @var string
      */
    protected $cursor;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["location_id"])) {
              $this->location_id = $data["location_id"];
            } else {
              $this->location_id = null;
            }
            if (isset($data["sort_order"])) {
              $this->sort_order = $data["sort_order"];
            } else {
              $this->sort_order = null;
            }
            if (isset($data["begin_time"])) {
              $this->begin_time = $data["begin_time"];
            } else {
              $this->begin_time = null;
            }
            if (isset($data["end_time"])) {
              $this->end_time = $data["end_time"];
            } else {
              $this->end_time = null;
            }
            if (isset($data["limit"])) {
              $this->limit = $data["limit"];
            } else {
              $this->limit = null;
            }
            if (isset($data["cursor"])) {
              $this->cursor = $data["cursor"];
            } else {
              $this->cursor = null;
            }
        }
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
     * @param string $location_id The ID of the location to query for a list of cash drawer shifts.
     * @return $this
     */
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
        return $this;
    }
    /**
     * Gets sort_order
     * @return string
     */
    public function getSortOrder()
    {
        return $this->sort_order;
    }
  
    /**
     * Sets sort_order
     * @param string $sort_order The order in which cash drawer shifts are listed in the response, based on their opened_at field. Default value: ASC See [SortOrder](#type-sortorder) for possible values
     * @return $this
     */
    public function setSortOrder($sort_order)
    {
        $this->sort_order = $sort_order;
        return $this;
    }
    /**
     * Gets begin_time
     * @return string
     */
    public function getBeginTime()
    {
        return $this->begin_time;
    }
  
    /**
     * Sets begin_time
     * @param string $begin_time The inclusive start time of the query on opened_at, in ISO 8601 format.
     * @return $this
     */
    public function setBeginTime($begin_time)
    {
        $this->begin_time = $begin_time;
        return $this;
    }
    /**
     * Gets end_time
     * @return string
     */
    public function getEndTime()
    {
        return $this->end_time;
    }
  
    /**
     * Sets end_time
     * @param string $end_time The exclusive end date of the query on opened_at, in ISO 8601 format.
     * @return $this
     */
    public function setEndTime($end_time)
    {
        $this->end_time = $end_time;
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
     * @param int $limit Number of cash drawer shift events in a page of results (200 by default, 1000 max).
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        return $this;
    }
    /**
     * Gets cursor
     * @return string
     */
    public function getCursor()
    {
        return $this->cursor;
    }
  
    /**
     * Sets cursor
     * @param string $cursor Opaque cursor for fetching the next page of results.
     * @return $this
     */
    public function setCursor($cursor)
    {
        $this->cursor = $cursor;
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
