<?php

namespace AllModules\CompanySymbol\Concretes;

use Suphle\Contracts\Config\ModuleFiles;

use Suphle\Queues\AdapterManager;

use Suphle\Services\UpdatelessService;

use AllModules\CompanySymbol\Tasks\SymbolReportTask;

class SymbolService extends UpdatelessService {

	private array $allSymbols = [];

	public function __construct (
		protected readonly ModuleFiles $fileConfig,

		protected readonly AdapterManager $queueManager
	) {

		//
	}

	public function getAllSymbols ():array {

		if (!empty($this->allSymbols)) return $this->allSymbols;

		return $this->allSymbols = json_decode(file_get_contents(

			$this->fileConfig->activeModulePath().

			"Json/nasdaq-listed_json.json"
		), true);
	}

	public function queueReport (array $reportPayload):void {

		$this->queueManager

		->addTask(SymbolReportTask::class, compact("reportPayload"));
	}

	public function findCompanyBySymbol (string $searchSymbol):?array {

		foreach ($this->getAllSymbols() as $symbolObject)

            if ($searchSymbol == $symbolObject["Symbol"])

            	return $symbolObject;

        return null;
	}
}