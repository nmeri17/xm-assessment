<?php

namespace AllModules\CompanySymbol\Tests\FeatureTests;

use Suphle\Hydration\Container;

use Suphle\Testing\{TestTypes\ModuleLevelTest, Proxies\WriteOnlyContainer};

use Suphle\Security\CSRF\CsrfGenerator;

use AllModules\CompanySymbol\{Meta\CompanySymbolDescriptor, Http\RapidHistoric, DTOs\SymbolHistory};

class HistoricChartTest extends ModuleLevelTest {

	protected const COMPANY_SYMBOL = "ABAX";

	private array $csrfField;

	private int $sampleSymbolTime;

	protected bool $debugCaughtExceptions = true;

	protected function setUp ():void {

		$this->sampleSymbolTime = time();

		parent::setUp();

		$this->csrfField = [

			CsrfGenerator::TOKEN_FIELD => $this->getContainer()

			->getClass(CsrfGenerator::class)->newToken()
		];
	}

	/**
	 * @return \Suphle\Modules\ModuleDescriptor[]
	 *
	 * @psalm-return list{\Suphle\Modules\ModuleDescriptor}
	 */
	protected function getModules ():array {

		return [
			$this->replicateModule(CompanySymbolDescriptor::class, function (WriteOnlyContainer $container) {

				$container->replaceWithMock(RapidHistoric::class, RapidHistoric::class, [

					"getDomainObject" => [new SymbolHistory(

						$this->sampleSymbolTime, 1, 2, 3, 4, 512
					)]
				]);
			})
		];
	}

	/**
	 * @return void
	 */
	public function test_can_render_company_historic_data () {

		$this->get("/Symbol/ABAX") // when

		->assertOk() // sanity check
		// then
		->assertSee("Showing Historical data for ABAXIS, Inc.")

		->assertSee("<td>". $this->sampleSymbolTime, false);
	}
}