<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * Error Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class Error implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'category' => 'string',
        'code' => 'string',
        'detail' => 'string',
        'field' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'category' => 'category',
        'code' => 'code',
        'detail' => 'detail',
        'field' => 'field'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'category' => 'setCategory',
        'code' => 'setCode',
        'detail' => 'setDetail',
        'field' => 'setField'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'category' => 'getCategory',
        'code' => 'getCode',
        'detail' => 'getDetail',
        'field' => 'getField'
    );
  
    /**
      * $category The high-level category for the error. See `ErrorCategory` for possible values. See [ErrorCategory](#type-errorcategory) for possible values
      * @var string
      */
    protected $category;
    /**
      * $code The specific code of the error. See `ErrorCode` for possible values See [ErrorCode](#type-errorcode) for possible values
      * @var string
      */
    protected $code;
    /**
      * $detail A human-readable description of the error for debugging purposes.
      * @var string
      */
    protected $detail;
    /**
      * $field The name of the field provided in the original request (if any) that the error pertains to.
      * @var string
      */
    protected $field;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["category"])) {
              $this->category = $data["category"];
            } else {
              $this->category = null;
            }
            if (isset($data["code"])) {
              $this->code = $data["code"];
            } else {
              $this->code = null;
            }
            if (isset($data["detail"])) {
              $this->detail = $data["detail"];
            } else {
              $this->detail = null;
            }
            if (isset($data["field"])) {
              $this->field = $data["field"];
            } else {
              $this->field = null;
            }
        }
    }
    /**
     * Gets category
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
  
    /**
     * Sets category
     * @param string $category The high-level category for the error. See `ErrorCategory` for possible values. See [ErrorCategory](#type-errorcategory) for possible values
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }
    /**
     * Gets code
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
  
    /**
     * Sets code
     * @param string $code The specific code of the error. See `ErrorCode` for possible values See [ErrorCode](#type-errorcode) for possible values
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }
    /**
     * Gets detail
     * @return string
     */
    public function getDetail()
    {
        return $this->detail;
    }
  
    /**
     * Sets detail
     * @param string $detail A human-readable description of the error for debugging purposes.
     * @return $this
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;
        return $this;
    }
    /**
     * Gets field
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }
  
    /**
     * Sets field
     * @param string $field The name of the field provided in the original request (if any) that the error pertains to.
     * @return $this
     */
    public function setField($field)
    {
        $this->field = $field;
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
