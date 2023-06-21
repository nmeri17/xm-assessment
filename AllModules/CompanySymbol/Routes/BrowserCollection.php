<?php
namespace AllModules\CompanySymbol\Routes;

use Suphle\Routing\{BaseCollection, Decorators\HandlingCoordinator};

use Suphle\Response\Format\{Markup, Redirect};

use AllModules\CompanySymbol\Coordinators\BaseCoordinator;

#[HandlingCoordinator(BaseCoordinator::class)]
class BrowserCollection extends BaseCollection {

	/**
	 * @return string
	 *
	 * @psalm-return 'SYMBOL'
	 */
	public function _prefixCurrent ():string {

		return "SYMBOL";
	}

	/**
	 * @return void
	 */
	public function ALL__SYMBOLSh () {

		$this->_httpGet(new Markup("showSymbols", "partials/show-symbols"));
	}

	/**
	 * @return void
	 */
	public function SUBMIT__SYMBOLh () {

		$this->_httpPost(new Redirect("handleSymbolSelect", function () {

			return "/Symbol/". $this->rawResponse["symbol"];
		}));
	}

	/**
	 * @return void
	 */
	public function id () {

		$this->_httpGet(new Markup("showSymbolChart", "partials/show-symbols-chart"));
	}
}