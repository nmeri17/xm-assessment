<?php

namespace AllModules\CompanySymbol\PayloadReaders;

use Suphle\Services\Structures\ModellessPayload;

use Suphle\Contracts\Response\RendererManager;

use AllModules\CompanySymbol\Concretes\SymbolService;

class SymbolDetailsReader extends ModellessPayload {

    use ValidatesSymbol;

    public function __construct (
    
        protected SymbolService $symbolService,

        protected RendererManager $rendererManager
    ) {

        //
    }

	protected function convertToDomainObject() {

        $payload = $this->payloadStorage->fullPayload();

        $this->tryValidateSymbol($payload["symbol"]);
        
        return $payload;
    }
}