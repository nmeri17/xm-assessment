<?php

namespace AllModules\CompanySymbol\Tests\FeatureTests;

use Suphle\Hydration\Container;

use Suphle\Testing\{TestTypes\ModuleLevelTest, Condiments\QueueInterceptor};

use Suphle\Security\CSRF\CsrfGenerator;

use AllModules\CompanySymbol\{Meta\CompanySymbolDescriptor, MailBuilders\SymbolReportMail};

use DateTime, DateInterval;

class IndexTest extends ModuleLevelTest {

	use QueueInterceptor {

		QueueInterceptor::setUp as queueSetup;
	}

	protected const COMPANY_SYMBOL = "ABAX";

	private array $csrfField;

	protected bool $debugCaughtExceptions = true;

	protected function setUp ():void {

		$this->queueSetup();

		$this->csrfField = [

			CsrfGenerator::TOKEN_FIELD => $this->getContainer()

			->getClass(CsrfGenerator::class)->newToken()
		];
	}

	protected function getModules ():array {

		return [new CompanySymbolDescriptor(new Container)];
	}

	public function test_loads_symbols_on_homepage () {

		$todaysDate = date('Y-m-d');

		$this->get("/symbol/") // when

		->assertOk() // sanity check
		// then
		->assertSee("<option value=\"". self::COMPANY_SYMBOL. "\">", false)

		->assertSee("ABAXIS, Inc.")

		->assertSee("<input type=\"date\" name=\"start_date\" required min=\"$todaysDate\" value=\"\">", false);
	}

	/**
	 * @depends test_loads_symbols_on_homepage
	*/
	public function test_invalid_payload_renders_errors () {

		$this->get("/Symbol"); // given

		$this->dataProvider([
		
			$this->getMissingFields(...)
		], function (array $payload, string $errorDetails) {

			$this->post("/symbol/submit-symbol", array_merge($this->csrfField, $payload)) // when
			// then
			->assertRedirect("/symbol")

			->assertSee($errorDetails);
		});
	}

	public function getMissingFields ():array {

		$payload1 = $this->getValidPayload();

		unset($payload1["symbol"]);

		return [

			[$payload1, "Validation errors"]
		];
	}

	public function test_success_queuing_mail () {

		$this->get("/Symbol"); // to have a rediret destination, just in case it fails

		$this->assertPushed(SymbolReportMail::class); // probably confirm this runs

		$this->post("/symbol/submit-symbol", $this->getValidPayload())

		->assertRedirect("/symbol/". self::COMPANY_SYMBOL);
	}

	protected function getValidPayload ():array {

		$today = new DateTime();

		$aWeekLater = $today->add(new DateInterval("P7D"));

		return array_merge($this->csrfField, [
			"symbol" => self::COMPANY_SYMBOL,
			"report_to" => "vainglories17@gmail.com",
			"start_date" => $today,
			"end_date" => $aWeekLater
		]);
	}
}