<?php

namespace AllModules\CompanySymbol\PayloadReaders;

use Suphle\Services\Structures\ModellessPayload;

use Suphle\Contracts\Response\RendererManager;

use AllModules\CompanySymbol\Concretes\SymbolService;

class ChartDetailsReader extends ModellessPayload {

    use ValidatesSymbol;

    public function __construct (
    
        protected SymbolService $symbolService,

        protected RendererManager $rendererManager
    ) {

        //
    }

    protected function convertToDomainObject() {

        $symbol = $this->pathPlaceholders->getSegmentValue("id");

        $this->tryValidateSymbol($symbol);
        
        return $symbol;
    }
}