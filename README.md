# SMSFactor Client library for PHP

This is the PHP client library for use SMSFactor's API.

In order to use it, make sure to have an account. You can register [here](https://www.smsfactor.com/en/registration/?utm_source=site-api&utm_campaign=Inscription&spid=17146). Once your account is created, you need to generate your first [API token](https://dev.smsfactor.com/en/api/sms/token/create-token).
You can find the complete documentation of our API [here](https://dev.smsfactor.com/).

# Installation

We recommend using [Composer](https://getcomposer.org/) to install the PHP client library to your project.

    composer require smsfactor/smsfactor-php-sdk


# Usage

Make sure to autoload the library in your bootstrap file :

```php
require_once __dir__ . 'vendor/autoload.php';
```

Set your token :

```php
\SMSFactor\SMSFactor::setApiToken('your token');
```
    
Send a message :

```php
$response = \SMSFactor\Message::send([
	'to' => '33601000000',
	'text' => 'Did you ever dance whith the devil in the pale moonlight ?'
]);
print_r($response->getJson());
```

# Examples

## Account

**Get credits**

```php
$response = \SMSFactor\Account::credits();
```

**Get account**

```php
$response = \SMSFactor\Account::get();
```

**Get subaccounts**

```php
$response = \SMSFactor\Account::subAccounts();
```

**Create an account**

```php
$response = \SMSFactor\Account::create([
	'account' => [
		"firstname" => "firstname",
		"lastname" => "lastname",
		"city" => "city",
		"phone" => "phone",
		"address1" => "address",
		"zip" => "zip",
		"country_code" => "country code",
		"isChild" => 0, //Is the account a subaccount ?
		"unlimited" => 0, //If isChild, should the subaccount use the parent's credits
		'email' => 'your@email.com',
		'password' => 'password'
	]
]);
```
## Campaign

**Send a campaign**

```php
$delay = date('Y-m-d H:i:s', strtotime('+1 hour')); // now + 1 hour
$response = \SMSFactor\Campaign::send([
    'sms' => [
	    'message' => [
		    'text' => 'test skd php',
		    'pushtype' => 'alert', //alert(default) or marketing
		    'sender' => 'SDK', //Optional
		    'delay' => $delay //Optional. Omit for immediate send
	    ],
	    'recipients' => [
		    'gsm' => [
			    [
				    'value' => '33601000000'
			    ]
		    ]
	    ]
    ]
], false); // True to simulate the campaign (no SMS sent)
```
**Send a campaign to a list**

   
```php
$delay = date('Y-m-d H:i:s', strtotime('+1 hour')); // now + 1 hour
$response = \SMSFactor\Campaign::send([
    'sms' => [
	    'message' => [
		    'text' => 'test skd php',
		    'pushtype' => 'alert', //alert(default) or marketing
		    'sender' => 'SDK', //Optional
		    'delay' => $delay //Optional. Omit for immediate send
	    ],
	    'lists' => [
		    [
			    'value' => 'your_list_id'
		    ]
	    ]
    ]
], false); // True to simulate the campaign (no SMS sent)
```

**Get information about a campaign**

Use the campaign ticket value returned by our API after sending a campaign to get information about that campaign. Given the last example :

```php
$response = \SMSFactor\Campaign::get($response->ticket);
```

**Cancel a delayed campaign**

```php
$response = \SMSFactor\Campaign::cancel($response->ticket);
```
   
**Get campaign history**

```php
$response = \SMSFactor\Campaign::history(['length' => 5]); //Get the last 5 campaigns
```

## List
**Create a liste**

You can customize each contact with up to 4 optional informations

```php
$response = \SMSFactor\ContactList::create([
    'list' => [
	    'name' => 'Your list name',
	    'contacts' => [
		    'gsm' => [
			    [
				    'value' => '33600000001',
				    'info1' => 'Lastname',
				    'info2' => 'Firstname',
				    'info3' => 'Gender'
			    ],
			    [
				    'value' => '33600000002',
				    'info1' => 'Lastname',
				    'info2' => 'Firstname',
				    'info3' => 'Gender'
			    ]
		    ]
	    ]
    ]
]);
$list_id = $response->id
```

**Add contacts to a list**

```php
$response = \SMSFactor\ContactList::create([
    'list' => [
	    'list_id' => $list_id
	    'contacts' => [
		    'gsm' => [
			    [
				    'value' => '33600000003',
				    'info1' => 'Lastname',
				    'info2' => 'Firstname',
				    'info3' => 'Gender'
			    ],
			    [
				    'value' => '33600000004',
				    'info1' => 'Lastname',
				    'info2' => 'Firstname',
				    'info3' => 'Gender'
			    ]
		    ]
	    ]
    ]
]);
```

**Get list**

```php
$response = \SMSFactor\ContactList::get($list_id);
```

**Remove a contact from a list**

```php
$response = \SMSFactor\ContactList::removeContact($contact_id); //use Get list to get contact id
```

**Deduplicate a list**

```php
$response = \SMSFactor\ContactList::deduplicate($list_id);
```
**Get all lists**

```php
$response = \SMSFactor\ContactList::all();
```
**Remove a list**

```php
$response = \SMSFactor\ContactList::delete($list_id);
```

**Add contacts to the blacklist**


   

```php
 $response = \SMSFactor\ContactList::create([
	'blacklist' => [
		'contacts' => [
			'gsm' => [
				[
					'value' => '33600000003'
				],
				[
					'value' => '33600000004'
				]
			]
		]
	]
]);
```
    
**Get blacklist**

```php
$response = \SMSFactor\ContactList::blacklist();
```

**Add contacts to the NPAI list**


   
```php
$response = \SMSFactor\ContactList::create([
	'npai' => [
		'contacts' => [
			'gsm' => [
				[
					'value' => '33600000003'
				],
				[
					'value' => '33600000004'
				]
			]
		]
	]
]);
```

**Get NPAI list**

```php
$response = \SMSFactor\ContactList::npai();
```

## Token

**Create a token**

```php
$response = \SMSFactor\Token::create([
    'token' => [
	    'name' => 'token sdk'
    ]
]);
$token = $response->token;
$token_id = $response->token_id;
```
    
**Get your tokens**

```php
$response = \SMSFactor\Token::all();
```

**Delete a token**

```php
$response = \SMSFactor\Token::delete($token_id);
```

## Webhook
To see all available webhooks, please go to our [official documentation](https://dev.smsfactor.com).

**Create a webhook**

   
```php
$response = \SMSFactor\Webhook::create([
	'webhook' => [
		'type' => 'DLR',
		'url' => 'https://yourserverurl.com'
	]
]);
$webhook_id = $response->webhook->webhook_id;
```
    
**Get your webhooks**

```php
$response = \SMSFactor\Webhook::all();
```

**Update a webhook**

```php
$response = \SMSFactor\Webhook::update($webhook_id, [
    'webhook' => [
	    'type' => 'MO',
	    'url' => 'https://yourserverurl.net'
    ]
]);
```

**Delete a webhook**

```php
$response = \SMSFactor\Webhook::delete($webhook_id);
```
    

