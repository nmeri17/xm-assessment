<?php

namespace AllModules\CompanySymbol\PayloadReaders;

use Suphle\Services\Structures\ModellessPayload;

use Suphle\Exception\Explosives\ValidationFailure;

use Suphle\Contracts\Response\RendererManager;

use AllModules\CompanySymbol\Concretes\SymbolService;

trait ValidatesSymbol {

    protected SymbolService $symbolService;

    protected RendererManager $rendererManager;

    protected function tryValidateSymbol (string $incomingSymbol):void {

        $matchingSymbol = false;

        // in real life, data will be read from database, and validation won't be manual
        foreach ($this->symbolService->getAllSymbols() as $symbolObject)

            if ($incomingSymbol == $symbolObject["Symbol"]) {

                $matchingSymbol = true;

                break;
            }

        if (!$matchingSymbol)

            throw new ValidationFailure($this->rendererManager);
    }

    // rethrow for it to skip the coordinator
    protected function translationFailure(): void
    {

        throw $this->exception;
    }
}