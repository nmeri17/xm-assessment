<?php
namespace AllModules\CompanySymbol\Coordinators;

use Suphle\Services\{ServiceCoordinator, Decorators\ValidationRules};

use Suphle\Security\CSRF\CsrfGenerator;

use AllModules\CompanySymbol\Concretes\SymbolService;

use AllModules\CompanySymbol\PayloadReaders\{SymbolDetailsReader, ChartDetailsReader};

use AllModules\CompanySymbol\Http\RapidHistoric;

class BaseCoordinator extends ServiceCoordinator {

	public function __construct (
	
		protected readonly SymbolService $symbolService,

		protected readonly CsrfGenerator $csrf,

		protected readonly RapidHistoric $historicApi
	) {

		//
	}

	public function showSymbols ():array {

		return [
		
			"allSymbols" => $this->symbolService->getAllSymbols(),

			"csrf_token" => $this->csrf->newToken()
		];
	}

	#[ValidationRules([

		"symbol" => "required|alpha:ascii",
		"report_to" => "required|email",
		"start_date" => "required|date|after_or_equal:today",
		"end_date" => "required|date|after:start_date"
	])]
	public function handleSymbolSelect (SymbolDetailsReader $symbolReader):array {

		$payload = $symbolReader->getDomainObject();

		$this->symbolService->queueSymbolReport($payload);

		return ["symbol" => $payload["symbol"]];
	}

	#[ValidationRules([

		"symbol" => "required|alpha:ascii"
	])]
	public function showSymbolChart (ChartDetailsReader $chartReader):array {

		$symbolId = $chartReader->getDomainObject();

		return [
			"companyName" => $this->symbolService

			->findCompanyBySymbol($symbolId)["Company Name"],
		
			"historicData" => $this->historicApi->setSymbol($symbolId)

			->getDomainObject()
		];
	}
}