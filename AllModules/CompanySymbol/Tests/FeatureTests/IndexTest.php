<?php

namespace AllModules\CompanySymbol\Tests\FeatureTests;

use Suphle\Hydration\Container;

use Suphle\Testing\{TestTypes\ModuleLevelTest, Condiments\QueueInterceptor, Utilities\ArrayAssertions};

use Suphle\Security\CSRF\CsrfGenerator;

use AllModules\CompanySymbol\{Meta\CompanySymbolDescriptor, Tasks\SymbolReportTask};

use DateTime, DateInterval;

class IndexTest extends ModuleLevelTest {

	use QueueInterceptor, ArrayAssertions {

		QueueInterceptor::setUp as queueSetup;
	}

	protected const COMPANY_SYMBOL = "ABAX";

	// protected bool $debugCaughtExceptions = true;

	/**
	 * @return array
	 *
	 * @psalm-return array{_csrf_token: mixed}
	 */
	protected function getCsrfField ():array {

		return [

			CsrfGenerator::TOKEN_FIELD => $this->getContainer()

			->getClass(CsrfGenerator::class)->newToken()
		];
	}

	/**
	 * @return CompanySymbolDescriptor[]
	 *
	 * @psalm-return list{CompanySymbolDescriptor}
	 */
	protected function getModules ():array {

		return [new CompanySymbolDescriptor(new Container)];
	}

	/**
	 * @return void
	 */
	public function test_loads_symbols_on_homepage () {

		$todaysDate = date('Y-m-d');

		$this->get("/symbol/all-symbols") // when

		->assertOk() // sanity check
		// then
		->assertSee("<option value=\"". self::COMPANY_SYMBOL. "\">", false)

		->assertSee("ABAXIS, Inc.")

		->assertSee("<input type=\"date\" name=\"start_date\" required min=\"$todaysDate\" value=\"\">", false);
	}

	/**
	 * @depends test_loads_symbols_on_homepage
	 *
	 * @return void
	 */
	public function test_invalid_payload_renders_errors () {

		$this->get("/Symbol/all-symbols"); // given

		$this->dataProvider([
		
			$this->getMissingFields(...)
		], function (array $payload, string $missingKey) {

			$response = $this->post("/symbol/submit-symbol", array_merge($this->getCsrfField(), $payload)) // when
			// then
			->assertRedirect("/Symbol/all-symbols");

			$sessionPayload = $response->session()->allSessionEntries();

			$this->assertArrayHasPath(

				$sessionPayload,

				"_flash_entry.validation_errors.$missingKey"
			);
		});
	}

	/**
	 * @return ((mixed|string)[]|string)[][]
	 *
	 * @psalm-return list{list{array{report_to: 'vainglories17@gmail.com', start_date: string, end_date: string,...}, 'symbol'}}
	 */
	public function getMissingFields ():array {

		$payload1 = $this->getValidPayload();

		unset($payload1["symbol"]);

		return [

			[$payload1, "symbol"]
		];
	}

	/**
	 * @return void
	 */
	public function test_success_queuing_mail () {

		$this->get("/Symbol/all-symbols"); // to have a rediret destination, just in case it fails

		$this->post("/symbol/submit-symbol", $this->getValidPayload())

		->assertRedirect("/Symbol/". self::COMPANY_SYMBOL);

		$this->assertPushed(SymbolReportTask::class); // probably confirm this runs
	}

	/**
	 * @return (mixed|string)[]
	 *
	 * @psalm-return array{_csrf_token: mixed, symbol: 'ABAX', report_to: 'vainglories17@gmail.com', start_date: string, end_date: string}
	 */
	protected function getValidPayload ():array {

		$aWeekLater = (new DateTime())->add(new DateInterval("P7D"));

		return array_merge($this->getCsrfField(), [
			"symbol" => self::COMPANY_SYMBOL,
			
			"report_to" => "vainglories17@gmail.com",
			
			"start_date" => (new DateTime())->format("Y-m-d"),
			
			"end_date" => $aWeekLater->format("Y-m-d")
		]);
	}
}