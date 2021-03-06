<?php

require ('vendor/autoload.php');

use Pinvoice\Pipedrive\API as PipedriveAPI;

class DealTest extends PHPUnit_Framework_TestCase {

	/**
	 * Set up and test Pipedrive API connection, and get all Deals.
	 */
	public function setUp() {
		$this->pipedrive = new PipedriveAPI(getenv('TOKEN'));

		if (!$this->pipedrive->isAuthenticated()) {
			$this->markTestSkipped('Cannot authenticate with Pipedrive.');
		}

		$this->deals = $this->pipedrive->deals->getDeals();

		if (is_null($this->deals)) {
			$this->markTestSkipped('There are no Deals available to test with.');
		}
	}

	/**
	 * Yes we can, or else setUp() would have failed.
	 */
	public function testCanGetDeals() {
		$this->pipedrive->deals->getDeals();
	}

	/**
	 * Try to get single Deal.
	 */
	public function testCanGetSingleDeal() {
		// Try to get the first Deal and compare the add_time.
		$firstDealInDeals = $this->deals[0];
		$deal = $this->pipedrive->deals->getDeal($firstDealInDeals->id);

		$this->assertEquals($firstDealInDeals->add_time, $deal->add_time);
	}
}
