<?php
namespace AllModules\CompanySymbol\Coordinators;

use Suphle\Services\{ServiceCoordinator, Decorators\ValidationRules};

use Suphle\Security\CSRF\CsrfGenerator;

use Suphle\Contracts\IO\Session;

use AllModules\CompanySymbol\Concretes\SymbolService;

use AllModules\CompanySymbol\PayloadReaders\{SymbolDetailsReader, ChartDetailsReader};

use AllModules\CompanySymbol\Http\RapidHistoric;

class BaseCoordinator extends ServiceCoordinator {

	public function __construct (

		protected readonly Session $sessionClient,
	
		protected readonly SymbolService $symbolService,

		protected readonly CsrfGenerator $csrf,

		protected readonly RapidHistoric $historicApi
	) {

		//
	}

	/**
	 * @return (array|string)[]
	 *
	 * @psalm-return array{allSymbols: array, csrf_token: string}
	 */
	public function showSymbols ():array {

		return $this->copyValidationErrors([
		
			"allSymbols" => $this->symbolService->getAllSymbols(),

			"csrf_token" => $this->csrf->newToken()
		]);
	}

	/**
	 * @return array
	 *
	 * @psalm-return array{symbol: mixed}
	 */
	#[ValidationRules([

		"symbol" => "required|alpha:ascii",
		"report_to" => "required|email",
		"start_date" => "required|date|after_or_equal:today",
		"end_date" => "required|date|after:start_date"
	])]
	public function handleSymbolSelect (SymbolDetailsReader $symbolReader):array {

		$payload = $symbolReader->getDomainObject();

		$this->symbolService->queueReport($payload);

		return ["symbol" => $payload["symbol"]];
	}

	/**
	 * @return (\Suphle\Services\Nullable|mixed|null)[]
	 *
	 * @psalm-return array{companyName: mixed|null, historicData: \Suphle\Services\Nullable}
	 */
	#[ValidationRules([

		"id" => "required|alpha:ascii"
	])]
	public function showSymbolChart (ChartDetailsReader $chartReader):array {

		$symbolId = $chartReader->getDomainObject();

		return [
			"companyName" => $this->symbolService

			->findCompanyBySymbol($symbolId)["Company Name"],
		
			"historicData" => $this->historicApi->setSymbol($symbolId)

			->getDomainObject() ?? []
		];
	}
}