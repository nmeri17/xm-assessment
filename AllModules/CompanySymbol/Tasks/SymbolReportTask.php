<?php

namespace AllModules\CompanySymbol\Tasks;

use Suphle\Contracts\Queues\Task;

use AllModules\CompanySymbol\MailBuilders\SymbolReportMail;

class SymbolReportTask implements Task {

	public function __construct (

		protected readonly array $reportPayload,

		protected readonly SymbolReportMail $mailBuilder
	) {

		//
	}

	public function handle ():void {

		$this->mailBuilder->setPayload($this->reportPayload)->sendMessage();
	}
}