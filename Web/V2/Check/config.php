<?php
$config = array (
		//应用ID,您的APPID。
		'app_id' => "201909266781989",

		//商户私钥，您的原始格式私钥,一行字符串
		'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCl7HlLxgY/BZxAiUFuB+XB4tuZctkHseUFWsNXnPEDRPAoXJR0y44hXofHWMV0b1/Sj+vA3GQLvwrlA9evLMhtJwV6TTlG/ZejhhDSyP2lPhuazen6hvftGFZE5gwkNC9tRe91gJ8n3cUsJ40wNs8xaNdq6CoxoN9c1G5NWT9SsOxLDJ2XrUWTLxatELRB3fjQiFWRca6fpIQjnbFvkYm1EPUdnSINvBKJivCg/vc385ujP7hOg1OOtrIqfG2qCWU4SSRz0v/9rOm0jt/8M+IFOtDtcR5BZt8Vx0MOwFjbc5h4sqJ5VdytxG2qo2e1ZGIVtU/EnL7b4rUrE2vmcVqLAgMBAAECggEAEd/LoVIP0jI0hu9CUSwgoCZkKb+piZ6sYUtJx+JsREHk7TQr+fkDsqyQS/VQMB7fX7uJVhln3awS7GDhl0lnvfp6KJaxGOiwsTj8Dvj/+hEawC52ijqH8s6wXHO70xqcEVV7WlkkzBKj7wHDv/HnmBcHPckM4pPF/CYWS9bVb37ace8Wo3+xMA9VCQ9p8LZGUtDAWty5oEr2kuPoqOfS/QpOlAFlfugLAhA0VL/LrwUqB78imG0/wML/doKHCiwUJYuOIqZD29J6sM9U+Xlrx/s7C1+nRvjBeOS4h4JK8wiNc6qH0ct5VuqUX0Z1p6vyPWdIj9CZlGVQJmqAHvfigQKBgQD62EeNO0hvnRps5LILWqjF7hQsMlvFsh3k8j+vIS5dCC7KPS0dCXlOfHvpN3Tnpq1LbCXrlFjYA8bykqInjPnmfZVQ5M0SXevXkTmofLH388rGvm+PHqlqL60jSgwfWFWPZVwVUy8ebzZ37hjrc6GHtdSksR3UvWd+FO0TQIT0GwKBgQCpVWpkPyfknpnq5H3hUfOHjMRmcsWvBNs5BAYhK7Rm83jhZr9yzYYkI0ddGQk/VFN5X9DCJ629UbClk23e9oLdYhegkZ6RKAJk1og1AMxrr2y9N3c8zSnurLsR1gG7tlXb9ZrikTfjuUNvEd5JRQn/5D8FCQK1JHfcAnkS1FY6UQKBgQCLavPxyjZLWq0aQs22Q9A0Gkv5+I9LROEao43Dv5RuPqMK4o+VaPOULNoN2DXQnrIIjnZRBiWPAiJsJhWcF925PqljyZc1EyCGsn+yZoPfxQ86ARQuHqOYkiEP0RMFxOnhBjv02kQBDVzfsWUGUEFCFUy3sH1dBVxlFipiHeUHawKBgC81V/7wuI99RA3/e7S4oztUHGEveDtuECwaGhdfVuEo2beFbLR15gLnLvsegrx8JvV8p/epFj/kqWnP616wvRU5RrsGPf3b+KbiRID6YwNWmes6rmxuClW3JEQ5tKv/jnpPQ8oMkFdVjB5IDf/BVqNXn9Yoh++2ZhAZRGXietOxAoGAVDgQfmeSp7GoXq2bxFH0obYCZuOrSzzXHfVNoOeHyc7Xp86g2lFELpoRtlQWADz7KKMFHg+7ucz00x6gt2u0E6I4qmTQ3jez6vNaaRaV7qKTKlVJPVhZG1yODyABJZmIJhjzXa0kQ15ejT4kDEOax7IqhwiGcuwLLMsNy+fqc0g=",



		//商户应用公钥,一行字符串
		'merchant_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEApex5S8YGPwWcQIlBbgflweLbmXLZB7HlBVrDV5zxA0TwKFyUdMuOIV6Hx1jFdG9f0o/rwNxkC78K5QPXryzIbScFek05Rv2Xo4YQ0sj9pT4bms3p+ob37RhWROYMJDQvbUXvdYCfJ93FLCeNMDbPMWjXaugqMaDfXNRuTVk/UrDsSwydl61Fky8WrRC0Qd340IhVkXGun6SEI52xb5GJtRD1HZ0iDbwSiYrwoP73N/Oboz+4ToNTjrayKnxtqgllOEkkc9L//azptI7f/DPiBTrQ7XEeQWbfFcdDDsBY23OYeLKieVXcrcRtqqNntWRiFbVPxJy+2+K1KxNr5nFaiwIDAQAB",



		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkozftHh3pzBYgdQE4UMn/mM/+1I0JqZrzj80Yuqoaqlf8OMGNPOzasgdzLs/333GwoARaJcWxcXnTs4FLadBO4wcy6a/x7h8r8o/jG6bpgXeHSMnjlzUlf10QoBX5LKE62xX5yvFVxeFU2ObN01a5EVecxv2w5q5ohb9EYq82WJliX1iNshhzGAksoIMk2rOB2BbX3J9fk9ay2jL1eeybARMOEL7d7FSCqVr4rgOf4kKbXa6mGiyl9T+rrqO++IWKXq4Gog2c0GlUcsuI5HIalEZGMOzTjwKeTMz5mGaLOcakoLqewkGY6d91mXN5kIupx6sX67bbBkPuGVfsX01pQIDAQAB",


		//编码格式只支持GBK。
		'charset' => "GBK",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//签名方式
		'sign_type'=>"RSA2"
);