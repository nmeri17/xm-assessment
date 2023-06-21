<?php
namespace AllModules\CompanySymbol\Routes;

use Suphle\Routing\{BaseCollection, Decorators\HandlingCoordinator};

use Suphle\Response\Format\{Markup, Redirect};

use AllModules\CompanySymbol\Coordinators\BaseCoordinator;

#[HandlingCoordinator(BaseCoordinator::class)]
class BrowserCollection extends BaseCollection {

	public function _prefixCurrent ():string {

		return "SYMBOL";
	}

	public function _index () {

		$this->_httpGet(new Markup("showSymbols", "partial/show-symbols"));
	}

	public function SUBMIT__SYMBOLh () {

		$this->_httpPost(new Redirect("handleSymbolSelect", function () {

			return "/Symbol/". $this->rawResponse["symbol"];
		}));
	}

	public function id () {

		$this->_httpGet(new Markup("showSymbolChart", "partial/show-symbol-chart"));
	}
}