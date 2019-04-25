<?php

namespace SMSFactor\Test;

use PHPUnit\Framework\TestCase;

class SMSFactorTest extends TestCase {

	protected $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIyMTEyNCIsImlhdCI6MTU1NjAxMDEyNX0.mvbtwke3ji2UZ_npySJ-LTepr5NEud9BIdtBT68RgXQ';

	public function setUp()
    {
        \SMSFactor\SMSFactor::setApiToken($this->token);
    }

    /** Account **/

    public function testGetCredits()
    {
		$response = \SMSFactor\Account::credits();
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('credits', $decoded_body);
    }

    public function testGetAccount()
    {
		$response = \SMSFactor\Account::get();
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('account', $decoded_body);
    }

    public function testGetSubAccounts()
    {
		$response = \SMSFactor\Account::subAccounts();
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('sub-accounts', $decoded_body);
		$this->assertInternalType('array', $response->{'sub-accounts'});
    }

    public function testCreateAccount()
    {

		$response = \SMSFactor\Account::create([
			'account' => [
				"firstname" => "George",
			    "lastname" => "Abitbol",
			    "city" => "Pluvigner",
			    "phone" => "0011223344",
			    "address1" => "3 avenue du président Coty",
			    "zip" => "56330",
			    "country_code" => "fr",
			    "isChild" => 0,
			    "unlimited" => 0,
				'email' => 'g.abitbol+' . uniqid() . '@smsfactor.com',
				'password' => 'edR3meDeDn0m'
			]
		]);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('id', $decoded_body);
    }

    /** Campaign **/

    public function testCampaignSend()
    {
    	$delay = date('Y-m-d H:i:s', strtotime('+1 hour')); // now + 1 hour
	    $response = \SMSFactor\Campaign::send([
			'sms' => [
				'message' => [
					'text' => 'test skd php',
					'pushtype' => 'alert',
					'sender' => 'SDK',
					'delay' => $delay
				],
				'recipients' => [
					'gsm' => [
						[
							'value' => '33601000000'
						]
					]
				]
			]
		], false);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('ticket', $decoded_body);
		return $response->ticket;
	}

	/**
     * @depends testCampaignSend
     */
	public function testCampaignGet($ticket)
    {
		$response = \SMSFactor\Campaign::get($ticket);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('campaign', $decoded_body);
	}

	/**
     * @depends testCampaignSend
     */
	public function testCampaignCancel($ticket)
    {
	    $response = \SMSFactor\Campaign::cancel($ticket);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('credits', $decoded_body);
	}

	public function testCampaignHistory()
    {
		$response = \SMSFactor\Campaign::history(['length' => 1]);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('campaigns', $decoded_body);
	}

	/** List **/

	public function testCreateList()
    {
		$response = \SMSFactor\ContactList::create([
			'list' => [
				'name' => 'sdk list',
				'contacts' => [
					'gsm' => [
						[
							'value' => '33600000001',
							'info1' => 'contact 1'
						],
						[
							'value' => '33600000002',
							'info2' => 'contact 2'
						]
					]
				]
			]
		]);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('contacts', $decoded_body);
		$this->assertObjectHasAttribute('id', $decoded_body);
		$this->assertEquals(2, $decoded_body->contacts);
		return $response->id;
	}

	/**
     * @depends testCreateList
     */
	public function testAddContactToList($list_id)
    {
		$response = \SMSFactor\ContactList::addContacts([
			'list' => [
				'listId' => $list_id,
				'contacts' => [
					'gsm' => [
						[
							'value' => '33600000005',
							'info1' => 'contact 3',
							'info3' => 'contact 3'
						],
						[
							'value' => '33600000005',
							'info2' => 'contact 4',
							'info4' => 'contact 4'
						]
					]
				]
			]
		]);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('contacts', $decoded_body);
		$this->assertObjectHasAttribute('id', $decoded_body);
		$this->assertEquals(2, $decoded_body->contacts);
		return $response->id;
	}

	/**
     * @depends testAddContactToList
     */
	public function testCampaignSendToLists($list_id)
    {
	    $response = \SMSFactor\Campaign::sendToLists([
			'sms' => [
				'message' => [
					'text' => 'test skd php',
					'pushtype' => 'alert',
					'sender' => 'SDK'
				],
				'lists' => [
					[
						'value' => $list_id
					]
				]
			]
		], true);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('ticket', $decoded_body);
		return $list_id;
	}

	/**
     * @depends testCampaignSendToLists
     */
	public function testGetList($list_id)
    {
	    $response = \SMSFactor\ContactList::get($list_id);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('list', $decoded_body);
		$contact_id = $decoded_body->list[0]->id;
		return $contact_id;
	}

	/**
     * @depends testGetList
     */
	public function testRemoveContact($contact_id)
    {
	    $response = \SMSFactor\ContactList::removeContact($contact_id);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
	}

	/**
     * @depends testAddContactToList
     */
	public function testDeduplicateList($list_id)
    {
	    $response = \SMSFactor\ContactList::deduplicate($list_id);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('removed', $decoded_body);
		return $list_id;
	}

	public function testGetLists()
    {
	    $response = \SMSFactor\ContactList::all();
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('lists', $decoded_body);
	}

	/**
     * @depends testDeduplicateList
     */
	public function testRemoveList($list_id)
    {
	    $response = \SMSFactor\ContactList::delete($list_id);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
	}

	public function testAddToBlacklist()
    {
	    $response = \SMSFactor\ContactList::addToBlacklist([
			'blacklist' => [
				'contacts' => [
					'gsm' => [
						[
							'value' => '33600000015',
							'info1' => 'contact 1'
						],
						[
							'value' => '33600000016',
							'info2' => 'contact 2'
						]
					]
				]
			]
		]);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('added_contacts', $decoded_body);
		$this->assertEquals(2, $decoded_body->added_contacts);
	}

	public function testGetBlacklist()
    {
	    $response = \SMSFactor\ContactList::blacklist();
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('list', $decoded_body);
	}

	public function testAddToNPAI()
    {
	    $response = \SMSFactor\ContactList::addToNpai([
			'npai' => [
				'contacts' => [
					'gsm' => [
						[
							'value' => '33600000017',
							'info1' => 'contact 1'
						],
						[
							'value' => '33600000018',
							'info2' => 'contact 2'
						]
					]
				]
			]
		]);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('added_contacts', $decoded_body);
		$this->assertEquals(2, $decoded_body->added_contacts);
	}

	public function testGetNPAI()
    {
	    $response = \SMSFactor\ContactList::npai();
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('list', $decoded_body);
	}

	/** Message **/

	public function testSendMessage()
    {
	    $response = \SMSFactor\Message::send([
			'to' => '33601000000',
			'text' => 'Did you ever dance whith the devil in the pale moonlight'
		], true);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('ticket', $decoded_body);
	}

	/** Token **/

	public function testCreateToken()
    {
	    $response = \SMSFactor\Token::create([
			'token' => [
				'name' => 'token sdk'
			]
		]);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('token', $decoded_body);
		$this->assertObjectHasAttribute('token_id', $decoded_body);
		return $response->token_id;
	}

	public function testGetTokens()
    {
	    $response = \SMSFactor\Token::all();
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('tokens', $decoded_body);
	}

	/**
     * @depends testCreateToken
     */
	public function testDeleteToken($token_id)
    {
	    $response = \SMSFactor\Token::delete($token_id);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('deleted_token', $decoded_body);
	}

	/** Webhook **/

	public function testCreateWebhook()
    {
	    $response = \SMSFactor\Webhook::create([
			'webhook' => [
				'type' => 'DLR',
				'url' => 'https://yourserverurl.com'
			]
		]);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('webhook', $decoded_body);
		$this->assertObjectHasAttribute('webhook_id', $decoded_body->webhook);
		return $response->webhook->webhook_id;
	}

	/**
     * @depends testCreateWebhook
     */
	public function testUpdateWebhook($webhook_id)
    {
	    $response = \SMSFactor\Webhook::update($webhook_id, [
			'webhook' => [
				'type' => 'MO',
				'url' => 'https://yourserverurl.net'
			]
		]);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('webhook', $decoded_body);
		$this->assertObjectHasAttribute('webhook_id', $decoded_body->webhook);
		return $response->webhook->webhook_id;
	}

	public function testGetWebhooks()
    {
	    $response = \SMSFactor\Webhook::all();
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('webhooks', $decoded_body);
	}

	/**
     * @depends testUpdateWebhook
     */
	public function testDeleteWebhook($webhook_id)
    {
	    $response = \SMSFactor\Webhook::delete($webhook_id);
		$this->assertInstanceOf('\SMSFactor\APIResponse', $response);
		$this->assertAttributeEquals(200, 'code', $response);
		$this->assertEquals(1, $response->status);
		$decoded_body = $response->getJson();
		$this->assertObjectHasAttribute('deleted_id', $decoded_body);
	}

	public function testAuthenticationFail()
    {
    	\SMSFactor\SMSFactor::setApiToken('');
    	$this->expectException(\SMSFactor\Error\Authentication::class);
	    \SMSFactor\Account::credits();
	}

	public function testErrorGetters(){

    	\SMSFactor\SMSFactor::setApiToken('1');
    	try{
	    	\SMSFactor\Account::credits();
	    } catch(\SMSFactor\Error\Authentication $e) {
	    	$this->assertEquals(-1, $e->getSMSFactorCode());
	    	$this->assertEquals(200, $e->getHttpStatus());
	    	$this->assertInternalType('object', $e->getHttpBody());
	    	$this->assertInternalType('array', $e->getHttpHeaders());
	    	$this->assertInternalType('object', $e->getJsonBody());
	    	$this->assertInternalType('string', (string)$e);
	    }
	}


}
