# ListCashDrawerShiftEventsResponse

### Description



## Properties
Name | Getter | Setter | Type | Description | Notes
------------ | ------------- | ------------- | ------------- | ------------- | -------------
**events** | getEvents() | setEvents($value) | [**\SquareConnect\Model\CashDrawerShiftEvent[]**](CashDrawerShiftEvent.md) | All of the events (payments, refunds, etc.) for a cash drawer during the shift. | [optional] 
**cursor** | getCursor() | setCursor($value) | **string** | Opaque cursor for fetching the next page. Cursor is not present in the last page of results. | [optional] 
**errors** | getErrors() | setErrors($value) | [**\SquareConnect\Model\Error[]**](Error.md) | Any errors that occurred during the request. | [optional] 

Note: All properties are protected and only accessed via getters and setters.

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

