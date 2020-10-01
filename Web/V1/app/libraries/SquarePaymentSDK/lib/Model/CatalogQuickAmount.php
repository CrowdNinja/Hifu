<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * CatalogQuickAmount Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 * Note: This endpoint is in beta.
 */
class CatalogQuickAmount implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'type' => 'string',
        'amount' => '\SquareConnect\Model\Money',
        'score' => 'int',
        'ordinal' => 'int'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'type' => 'type',
        'amount' => 'amount',
        'score' => 'score',
        'ordinal' => 'ordinal'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'type' => 'setType',
        'amount' => 'setAmount',
        'score' => 'setScore',
        'ordinal' => 'setOrdinal'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'type' => 'getType',
        'amount' => 'getAmount',
        'score' => 'getScore',
        'ordinal' => 'getOrdinal'
    );
  
    /**
      * $type Represents the type of the Quick Amount. See [CatalogQuickAmountType](#type-catalogquickamounttype) for possible values
      * @var string
      */
    protected $type;
    /**
      * $amount Represents the actual amount of the Quick Amount with Money type.
      * @var \SquareConnect\Model\Money
      */
    protected $amount;
    /**
      * $score Describes the ranking of the Quick Amount provided by machine learning model, in the range [0, 100]. MANUAL type amount will always have score = 100.
      * @var int
      */
    protected $score;
    /**
      * $ordinal The order in which this Quick Amount should be displayed.
      * @var int
      */
    protected $ordinal;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["type"])) {
              $this->type = $data["type"];
            } else {
              $this->type = null;
            }
            if (isset($data["amount"])) {
              $this->amount = $data["amount"];
            } else {
              $this->amount = null;
            }
            if (isset($data["score"])) {
              $this->score = $data["score"];
            } else {
              $this->score = null;
            }
            if (isset($data["ordinal"])) {
              $this->ordinal = $data["ordinal"];
            } else {
              $this->ordinal = null;
            }
        }
    }
    /**
     * Gets type
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
  
    /**
     * Sets type
     * @param string $type Represents the type of the Quick Amount. See [CatalogQuickAmountType](#type-catalogquickamounttype) for possible values
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    /**
     * Gets amount
     * @return \SquareConnect\Model\Money
     */
    public function getAmount()
    {
        return $this->amount;
    }
  
    /**
     * Sets amount
     * @param \SquareConnect\Model\Money $amount Represents the actual amount of the Quick Amount with Money type.
     * @return $this
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }
    /**
     * Gets score
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }
  
    /**
     * Sets score
     * @param int $score Describes the ranking of the Quick Amount provided by machine learning model, in the range [0, 100]. MANUAL type amount will always have score = 100.
     * @return $this
     */
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }
    /**
     * Gets ordinal
     * @return int
     */
    public function getOrdinal()
    {
        return $this->ordinal;
    }
  
    /**
     * Sets ordinal
     * @param int $ordinal The order in which this Quick Amount should be displayed.
     * @return $this
     */
    public function setOrdinal($ordinal)
    {
        $this->ordinal = $ordinal;
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
