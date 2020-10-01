<?php
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace SquareConnect\Model;

use \ArrayAccess;
/**
 * PaymentRefund Class Doc Comment
 *
 * @category Class
 * @package  SquareConnect
 * @author   Square Inc.
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 * @link     https://squareup.com/developers
 */
class PaymentRefund implements ArrayAccess
{
    /**
      * Array of property to type mappings. Used for (de)serialization 
      * @var string[]
      */
    static $swaggerTypes = array(
        'id' => 'string',
        'status' => 'string',
        'location_id' => 'string',
        'amount_money' => '\SquareConnect\Model\Money',
        'app_fee_money' => '\SquareConnect\Model\Money',
        'processing_fee' => '\SquareConnect\Model\ProcessingFee[]',
        'payment_id' => 'string',
        'order_id' => 'string',
        'reason' => 'string',
        'created_at' => 'string',
        'updated_at' => 'string'
    );
  
    /** 
      * Array of attributes where the key is the local name, and the value is the original name
      * @var string[] 
      */
    static $attributeMap = array(
        'id' => 'id',
        'status' => 'status',
        'location_id' => 'location_id',
        'amount_money' => 'amount_money',
        'app_fee_money' => 'app_fee_money',
        'processing_fee' => 'processing_fee',
        'payment_id' => 'payment_id',
        'order_id' => 'order_id',
        'reason' => 'reason',
        'created_at' => 'created_at',
        'updated_at' => 'updated_at'
    );
  
    /**
      * Array of attributes to setter functions (for deserialization of responses)
      * @var string[]
      */
    static $setters = array(
        'id' => 'setId',
        'status' => 'setStatus',
        'location_id' => 'setLocationId',
        'amount_money' => 'setAmountMoney',
        'app_fee_money' => 'setAppFeeMoney',
        'processing_fee' => 'setProcessingFee',
        'payment_id' => 'setPaymentId',
        'order_id' => 'setOrderId',
        'reason' => 'setReason',
        'created_at' => 'setCreatedAt',
        'updated_at' => 'setUpdatedAt'
    );
  
    /**
      * Array of attributes to getter functions (for serialization of requests)
      * @var string[]
      */
    static $getters = array(
        'id' => 'getId',
        'status' => 'getStatus',
        'location_id' => 'getLocationId',
        'amount_money' => 'getAmountMoney',
        'app_fee_money' => 'getAppFeeMoney',
        'processing_fee' => 'getProcessingFee',
        'payment_id' => 'getPaymentId',
        'order_id' => 'getOrderId',
        'reason' => 'getReason',
        'created_at' => 'getCreatedAt',
        'updated_at' => 'getUpdatedAt'
    );
  
    /**
      * $id Unique ID for this refund, generated by Square.
      * @var string
      */
    protected $id;
    /**
      * $status The refund's status: - `PENDING` - awaiting approval - `COMPLETED` - successfully completed - `REJECTED` - the refund was rejected - `FAILED` - an error occurred
      * @var string
      */
    protected $status;
    /**
      * $location_id Location ID associated with the payment this refund is attached to.
      * @var string
      */
    protected $location_id;
    /**
      * $amount_money The amount of money refunded, specified in the smallest denomination of the applicable currency. For example, US dollar amounts are specified in cents.
      * @var \SquareConnect\Model\Money
      */
    protected $amount_money;
    /**
      * $app_fee_money Amount of money the app developer contributed to help cover the refunded amount. Specified in the smallest denomination of the applicable currency. For example, US dollar amounts are specified in cents. See [Working with monetary amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts) for details.
      * @var \SquareConnect\Model\Money
      */
    protected $app_fee_money;
    /**
      * $processing_fee Processing fees and fee adjustments assessed by Square on this refund.
      * @var \SquareConnect\Model\ProcessingFee[]
      */
    protected $processing_fee;
    /**
      * $payment_id The ID of the payment assocated with this refund.
      * @var string
      */
    protected $payment_id;
    /**
      * $order_id The ID of the order associated with the refund.
      * @var string
      */
    protected $order_id;
    /**
      * $reason The reason for the refund.
      * @var string
      */
    protected $reason;
    /**
      * $created_at Timestamp of when the refund was created, in RFC 3339 format.
      * @var string
      */
    protected $created_at;
    /**
      * $updated_at Timestamp of when the refund was last updated, in RFC 3339 format.
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
            if (isset($data["status"])) {
              $this->status = $data["status"];
            } else {
              $this->status = null;
            }
            if (isset($data["location_id"])) {
              $this->location_id = $data["location_id"];
            } else {
              $this->location_id = null;
            }
            if (isset($data["amount_money"])) {
              $this->amount_money = $data["amount_money"];
            } else {
              $this->amount_money = null;
            }
            if (isset($data["app_fee_money"])) {
              $this->app_fee_money = $data["app_fee_money"];
            } else {
              $this->app_fee_money = null;
            }
            if (isset($data["processing_fee"])) {
              $this->processing_fee = $data["processing_fee"];
            } else {
              $this->processing_fee = null;
            }
            if (isset($data["payment_id"])) {
              $this->payment_id = $data["payment_id"];
            } else {
              $this->payment_id = null;
            }
            if (isset($data["order_id"])) {
              $this->order_id = $data["order_id"];
            } else {
              $this->order_id = null;
            }
            if (isset($data["reason"])) {
              $this->reason = $data["reason"];
            } else {
              $this->reason = null;
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
     * @param string $id Unique ID for this refund, generated by Square.
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * @param string $status The refund's status: - `PENDING` - awaiting approval - `COMPLETED` - successfully completed - `REJECTED` - the refund was rejected - `FAILED` - an error occurred
     * @return $this
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * @param string $location_id Location ID associated with the payment this refund is attached to.
     * @return $this
     */
    public function setLocationId($location_id)
    {
        $this->location_id = $location_id;
        return $this;
    }
    /**
     * Gets amount_money
     * @return \SquareConnect\Model\Money
     */
    public function getAmountMoney()
    {
        return $this->amount_money;
    }
  
    /**
     * Sets amount_money
     * @param \SquareConnect\Model\Money $amount_money The amount of money refunded, specified in the smallest denomination of the applicable currency. For example, US dollar amounts are specified in cents.
     * @return $this
     */
    public function setAmountMoney($amount_money)
    {
        $this->amount_money = $amount_money;
        return $this;
    }
    /**
     * Gets app_fee_money
     * @return \SquareConnect\Model\Money
     */
    public function getAppFeeMoney()
    {
        return $this->app_fee_money;
    }
  
    /**
     * Sets app_fee_money
     * @param \SquareConnect\Model\Money $app_fee_money Amount of money the app developer contributed to help cover the refunded amount. Specified in the smallest denomination of the applicable currency. For example, US dollar amounts are specified in cents. See [Working with monetary amounts](https://developer.squareup.com/docs/build-basics/working-with-monetary-amounts) for details.
     * @return $this
     */
    public function setAppFeeMoney($app_fee_money)
    {
        $this->app_fee_money = $app_fee_money;
        return $this;
    }
    /**
     * Gets processing_fee
     * @return \SquareConnect\Model\ProcessingFee[]
     */
    public function getProcessingFee()
    {
        return $this->processing_fee;
    }
  
    /**
     * Sets processing_fee
     * @param \SquareConnect\Model\ProcessingFee[] $processing_fee Processing fees and fee adjustments assessed by Square on this refund.
     * @return $this
     */
    public function setProcessingFee($processing_fee)
    {
        $this->processing_fee = $processing_fee;
        return $this;
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
     * @param string $payment_id The ID of the payment assocated with this refund.
     * @return $this
     */
    public function setPaymentId($payment_id)
    {
        $this->payment_id = $payment_id;
        return $this;
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
     * @param string $order_id The ID of the order associated with the refund.
     * @return $this
     */
    public function setOrderId($order_id)
    {
        $this->order_id = $order_id;
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
     * Gets created_at
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
  
    /**
     * Sets created_at
     * @param string $created_at Timestamp of when the refund was created, in RFC 3339 format.
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
     * @param string $updated_at Timestamp of when the refund was last updated, in RFC 3339 format.
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
