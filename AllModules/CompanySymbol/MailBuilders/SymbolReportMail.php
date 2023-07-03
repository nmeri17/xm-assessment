<?php

namespace AllModules\CompanySymbol\MailBuilders;

use Suphle\IO\Mailing\MailBuilder;

use AllModules\CompanySymbol\Concretes\SymbolService;

use Suphle\Contracts\IO\MailClient;

class SymbolReportMail extends MailBuilder {

	public function __construct (
		protected readonly MailClient $mailClient,

		protected readonly SymbolService $symbolService
	) {

		//
	}

	public function sendMessage(): void {

        $company = $this->symbolService->findCompanyBySymbol($this->payload["symbol"]);

        $startDate = $this->payload["start_date"];

        $endDate = $this->payload["end_date"];

        $this->mailClient->setDestination( $this->payload["report_to"] )

        ->setSubject($company["Company Name"])
        
        ->setText("From $startDate to $endDate")->fireMail();
    }
}