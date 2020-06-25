# Sample Payloads

### Create User and Customer Information
*****POST** `/api/users/`
--- 
Payload:
```json
{
	"email": "customer_2@gmail.com",
	"password": "customer123",
	"firstName": "Customer Tetras",
	"lastName": "Tester",
	"mobile": "+639178660329",
	"info": {
		"billingAddress": "Danao St",
		"billingCity": "Ocala",
		"billingState": "Florida",
		"billingZipCode": "34480",
		"billingCountry": "United States of America",
		"shippingAddress": "Danao St",
		"shippingCity": "Ocala",
		"shippingState": "Florida",
		"shippingZipCode": "34480",
		"shippingCountry": "United States of America",
		"cc": "this should be encrypted"
	}
}
```
