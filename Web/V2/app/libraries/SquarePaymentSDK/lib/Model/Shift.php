<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * Shift Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class Shift implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'id' => 'string',
        'employee_id' => 'string',
        'location_id' => 'string',
        'timezone' => 'string',
        'start_at' => 'string',
        'end_at' => 'string',
        'wage' => '\SquareConnect\Model\ShiftWage',
        'breaks' => '\SquareConnect\Model\ModelBreak[]',
        'status' => 'string',
        'version' => 'int',
        'created_at' => 'string',
        'updated_at' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'id' => 'id',
        'employee_id' => 'employee_id',
        'location_id' => 'location_id',
        'timezone' => 'timezone',
        'start_at' => 'start_at',
        'end_at' => 'end_at',
        'wage' => 'wage',
        'breaks' => 'breaks',
        'status' => 'status',
        'version' => 'version',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'id' => 'setId',
        'employee_id' => 'setEmployeeId',
        'location_id' => 'setLocationId',
        'timezone' => 'setTimezone',
        'start_at' => 'setStartAt',
        'end_at' => 'setEndAt',
        'wage' => 'setWage',
        'breaks' => 'setBreaks',
        'status' => 'setStatus',
        'version' => 'setVersion',
        'created_at' => 'setCreatedAt',
        'updated_at' => 'setUpdatedAt'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'id' => 'getId',
        'employee_id' => 'getEmployeeId',
        'location_id' => 'getLocationId',
        'timezone' => 'getTimezone',
        'start_at' => 'getStartAt',
        'end_at' => 'getEndAt',
        'wage' => 'getWage',
        'breaks' => 'getBreaks',
        'status' => 'getStatus',
        'version' => 'getVersion',
        'created_at' => 'getCreatedAt',
        'updated_at' => 'getUpdatedAt'
    );
  
    /**
      * $id UUID for this object
      * @var string
      */
    protected $id;
    /**
      * $employee_id The ID of the employee this shift belongs to.
      * @var string
      */
    protected $employee_id;
    /**
      * $location_id The ID of the location this shift occurred at. Should be based on where the employee clocked in.
      * @var string
      */
    protected $location_id;
    /**
      * $timezone Read-only convenience value that is calculated from the location based on `location_id`. Format: the IANA Timezone Database identifier for the location timezone.
      * @var string
      */
    protected $timezone;
    /**
      * $start_at RFC 3339; shifted to location timezone + offset. Precision up to the minute is respected; seconds are truncated.
      * @var string
      */
    protected $start_at;
    /**
      * $end_at RFC 3339; shifted to timezone + offset. Precision up to the minute is respected; seconds are truncated. The `end_at` minute is not counted when the shift length is calculated. For example, a shift from `00:00` to `08:01` is considered an 8 hour shift (midnight to 8am).
      * @var string
      */
    protected $end_at;
    /**
      * $wage Job and pay related information. If wage is not set on create, will default to a wage of zero money. If title is not set on create, will default to the name of the role the employee is assigned to, if any.
      * @var \SquareConnect\Model\ShiftWage
      */
    protected $wage;
    /**
      * $breaks A list of any paid or unpaid breaks that were taken during this shift.
      * @var \SquareConnect\Model\ModelBreak[]
      */
    protected $breaks;
    /**
      * $status Describes working state of the current `Shift`. See [ShiftStatus](#type-shiftstatus) for possible values
      * @var string
      */
    protected $status;
    /**
      * $version Used for resolving concurrency issues; request will fail if version provided does not match server version at time of request. If not provided, Square executes a blind write; potentially overwriting data from another write.
      * @var int
      */
    protected $version;
    /**
      * $created_at A read-only timestamp in RFC 3339 format; presented in UTC.
      * @var string
      */
    protected $created_at;
    /**
      * $updated_at A read-only timestamp in RFC 3339 format; presented in UTC.
      * @var string
      */
    protected $updated_at;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["id"])) {
              $this->id = $data["id"];
            } else {
              $this->id = null;
            }
            if (isset($data["employee_id"])) {
              $this->employee_id = $data["employee_id"];
            } else {
              $this->employee_id = null;
            }
            if (isset($data["location_id"])) {
              $this->location_id = $data["location_id"];
            } else {
              $this->location_id = null;
            }
            if (isset($data["timezone"])) {
              $this->timezone = $data["timezone"];
            } else {
              $this->timezone = null;
            }
            if (isset($data["start_at"])) {
              $this->start_at = $data["start_at"];
            } else {
              $this->start_at = null;
            }
            if (isset($data["end_at"])) {
              $this->end_at = $data["end_at"];
            } else {
              $this->end_at = null;
            }
            if (isset($data["wage"])) {
              $this->wage = $data["wage"];
            } else {
              $this->wage = null;
            }
            if (isset($data["breaks"])) {
              $this->breaks = $data["breaks"];
            } else {
              $this->breaks = null;
            }
            if (isset($data["status"])) {
              $this->status = $data["status"];
            } else {
              $this->status = null;
            }
            if (isset($data["version"])) {
              $this->version = $data["version"];
            } else {
              $this->version = null;
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
        }
    }
    /**
     * Gets id
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
  
    /**
     * Sets id
     * @param string $id UUID for this object
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    /**
     * Gets employee_id
     * @return string
     */
    public function getEmployeeId()
    {
        return $this->employee_id;
    }
  
    /**
     * Sets employee_id
     * @param string $employee_id The ID of the employee this shift belongs to.
     * @return $this
     */
    public function setEmployeeId($employee_id)
    {
        $this->employee_id = $employee_id;
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
     * @param string $location_id The ID of the location this shift occurred at. Should be based on where the employee clocked in.
     * @return $this
     */
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
        return $this;
    }
    /**
     * Gets timezone
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
  
    /**
     * Sets timezone
     * @param string $timezone Read-only convenience value that is calculated from the location based on `location_id`. Format: the IANA Timezone Database identifier for the location timezone.
     * @return $this
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
        return $this;
    }
    /**
     * Gets start_at
     * @return string
     */
    public function getStartAt()
    {
        return $this->start_at;
    }
  
    /**
     * Sets start_at
     * @param string $start_at RFC 3339; shifted to location timezone + offset. Precision up to the minute is respected; seconds are truncated.
     * @return $this
     */
    public function setStartAt($start_at)
    {
        $this->start_at = $start_at;
        return $this;
    }
    /**
     * Gets end_at
     * @return string
     */
    public function getEndAt()
    {
        return $this->end_at;
    }
  
    /**
     * Sets end_at
     * @param string $end_at RFC 3339; shifted to timezone + offset. Precision up to the minute is respected; seconds are truncated. The `end_at` minute is not counted when the shift length is calculated. For example, a shift from `00:00` to `08:01` is considered an 8 hour shift (midnight to 8am).
     * @return $this
     */
    public function setEndAt($end_at)
    {
        $this->end_at = $end_at;
        return $this;
    }
    /**
     * Gets wage
     * @return \SquareConnect\Model\ShiftWage
     */
    public function getWage()
    {
        return $this->wage;
    }
  
    /**
     * Sets wage
     * @param \SquareConnect\Model\ShiftWage $wage Job and pay related information. If wage is not set on create, will default to a wage of zero money. If title is not set on create, will default to the name of the role the employee is assigned to, if any.
     * @return $this
     */
    public function setWage($wage)
    {
        $this->wage = $wage;
        return $this;
    }
    /**
     * Gets breaks
     * @return \SquareConnect\Model\ModelBreak[]
     */
    public function getBreaks()
    {
        return $this->breaks;
    }
  
    /**
     * Sets breaks
     * @param \SquareConnect\Model\ModelBreak[] $breaks A list of any paid or unpaid breaks that were taken during this shift.
     * @return $this
     */
    public function setBreaks($breaks)
    {
        $this->breaks = $breaks;
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
     * @param string $status Describes working state of the current `Shift`. See [ShiftStatus](#type-shiftstatus) for possible values
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * @param int $version Used for resolving concurrency issues; request will fail if version provided does not match server version at time of request. If not provided, Square executes a blind write; potentially overwriting data from another write.
     * @return $this
     */
    public function setVersion($version)
    {
        $this->version = $version;
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
     * @param string $created_at A read-only timestamp in RFC 3339 format; presented in UTC.
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
     * @param string $updated_at A read-only timestamp in RFC 3339 format; presented in UTC.
     * @return $this
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
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
