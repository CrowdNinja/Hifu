# RevokeTokenRequest

### Description



## Properties
Name | Getter | Setter | Type | Description | Notes
------------ | ------------- | ------------- | ------------- | ------------- | -------------
**client_id** | getClientId() | setClientId($value) | **string** | The Square issued ID for your application, available from the [application dashboard](https://connect.squareup.com/apps). | [optional] 
**access_token** | getAccessToken() | setAccessToken($value) | **string** | The access token of the merchant whose token you want to revoke. Do not provide a value for merchant_id if you provide this parameter. | [optional] 
**merchant_id** | getMerchantId() | setMerchantId($value) | **string** | The ID of the merchant whose token you want to revoke. Do not provide a value for access_token if you provide this parameter. | [optional] 
**revoke_only_access_token** | getRevokeOnlyAccessToken() | setRevokeOnlyAccessToken($value) | **bool** | If &#x60;true&#x60;, terminate the given single access token, but do not terminate the entire authorization. Default: &#x60;false&#x60; | [optional] 

Note: All properties are protected and only accessed via getters and setters.

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

