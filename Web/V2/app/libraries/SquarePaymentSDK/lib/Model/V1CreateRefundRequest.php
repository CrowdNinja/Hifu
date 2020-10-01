<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * V1CreateRefundRequest Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class V1CreateRefundRequest implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'payment_id' => 'string',
        'type' => 'string',
        'reason' => 'string',
        'refunded_money' => '\SquareConnect\Model\V1Money',
        'request_idempotence_key' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'payment_id' => 'payment_id',
        'type' => 'type',
        'reason' => 'reason',
        'refunded_money' => 'refunded_money',
        'request_idempotence_key' => 'request_idempotence_key'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'payment_id' => 'setPaymentId',
        'type' => 'setType',
        'reason' => 'setReason',
        'refunded_money' => 'setRefundedMoney',
        'request_idempotence_key' => 'setRequestIdempotenceKey'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'payment_id' => 'getPaymentId',
        'type' => 'getType',
        'reason' => 'getReason',
        'refunded_money' => 'getRefundedMoney',
        'request_idempotence_key' => 'getRequestIdempotenceKey'
    );
  
    /**
      * $payment_id The ID of the payment to refund. If you are creating a `PARTIAL` refund for a split tender payment, instead provide the id of the particular tender you want to refund.
      * @var string
      */
    protected $payment_id;
    /**
      * $type TThe type of refund (FULL or PARTIAL). See [V1CreateRefundRequestType](#type-v1createrefundrequesttype) for possible values
      * @var string
      */
    protected $type;
    /**
      * $reason The reason for the refund.
      * @var string
      */
    protected $reason;
    /**
      * $refunded_money The amount of money to refund. Required only for PARTIAL refunds.
      * @var \SquareConnect\Model\V1Money
      */
    protected $refunded_money;
    /**
      * $request_idempotence_key An optional key to ensure idempotence if you issue the same PARTIAL refund request more than once.
      * @var string
      */
    protected $request_idempotence_key;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property value initializing the model
     */
    public function __construct(array $data = null)
    {
        if ($data != null) {
            if (isset($data["payment_id"])) {
              $this->payment_id = $data["payment_id"];
            } else {
              $this->payment_id = null;
            }
            if (isset($data["type"])) {
              $this->type = $data["type"];
            } else {
              $this->type = null;
            }
            if (isset($data["reason"])) {
              $this->reason = $data["reason"];
            } else {
              $this->reason = null;
            }
            if (isset($data["refunded_money"])) {
              $this->refunded_money = $data["refunded_money"];
            } else {
              $this->refunded_money = null;
            }
            if (isset($data["request_idempotence_key"])) {
              $this->request_idempotence_key = $data["request_idempotence_key"];
            } else {
              $this->request_idempotence_key = null;
            }
        }
    }
    /**
     * Gets payment_id
     * @return string
     */
    public function getPaymentId()
    {
        return $this->payment_id;
    }
  
    /**
     * Sets payment_id
     * @param string $payment_id The ID of the payment to refund. If you are creating a `PARTIAL` refund for a split tender payment, instead provide the id of the particular tender you want to refund.
     * @return $this
     */
    public function setPaymentId($payment_id)
    {
        $this->payment_id = $payment_id;
        return $this;
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
     * @param string $type TThe type of refund (FULL or PARTIAL). See [V1CreateRefundRequestType](#type-v1createrefundrequesttype) for possible values
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    /**
     * Gets reason
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
  
    /**
     * Sets reason
     * @param string $reason The reason for the refund.
     * @return $this
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
        return $this;
    }
    /**
     * Gets refunded_money
     * @return \SquareConnect\Model\V1Money
     */
    public function getRefundedMoney()
    {
        return $this->refunded_money;
    }
  
    /**
     * Sets refunded_money
     * @param \SquareConnect\Model\V1Money $refunded_money The amount of money to refund. Required only for PARTIAL refunds.
     * @return $this
     */
    public function setRefundedMoney($refunded_money)
    {
        $this->refunded_money = $refunded_money;
        return $this;
    }
    /**
     * Gets request_idempotence_key
     * @return string
     */
    public function getRequestIdempotenceKey()
    {
        return $this->request_idempotence_key;
    }
  
    /**
     * Sets request_idempotence_key
     * @param string $request_idempotence_key An optional key to ensure idempotence if you issue the same PARTIAL refund request more than once.
     * @return $this
     */
    public function setRequestIdempotenceKey($request_idempotence_key)
    {
        $this->request_idempotence_key = $request_idempotence_key;
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
