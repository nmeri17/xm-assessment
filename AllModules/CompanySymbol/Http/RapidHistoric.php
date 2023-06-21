<?php

namespace AllModules\CompanySymbol\Http;

use Suphle\IO\Http\BaseHttpRequest;

use Psr\Http\Message\ResponseInterface;

use GuzzleHttp\RequestOptions;

use AllModules\CompanySymbol\DTOs\SymbolHistory;

class RapidHistoric extends BaseHttpRequest {

	private string $symbolToFetch;

	/**
	 * @return string
	 *
	 * @psalm-return 'https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data'
	 */
	public function getRequestUrl ():string {

		return "https://yh-finance.p.rapidapi.com/stock/v3/get-historical-data";
	}

	/**
	 * @return static
	 */
	public function setSymbol (string $symbolToFetch):self {

		$this->symbolToFetch = $symbolToFetch;

		return $this;
	}

	protected function getHttpResponse ():ResponseInterface {

		return $this->requestClient->request(
		
			"get", $this->getRequestUrl(), [

				RequestOptions::QUERY => [

					"symbol" => $this->symbolToFetch
				],
				RequestOptions::HEADERS => [

					"X-RapidAPI-Key" => $this->envAccessor->getField("RapidAPI_Key"),

					"X-RapidAPI-Host" => "yh-finance.p.rapidapi.com"
				]
		]);
	}

	/**
	 * @return SymbolHistory[]
	 *
	 * @psalm-return list{0?: SymbolHistory,...}
	 */
	protected function convertToDomainObject (ResponseInterface $response) {

		$collection = [];

		foreach ($response->toArray()["prices"] as $historyRow)

			$collection[] = new SymbolHistory(...$historyRow);

		return $collection;
	}
}