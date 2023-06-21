<?php
	namespace AllModules\CompanySymbol\Config;

	use Suphle\Config\Router;

	use AllModules\CompanySymbol\Routes\BrowserCollection;

	class RouterMock extends Router {

		public function browserEntryRoute ():?string {

			return BrowserCollection::class;
		}
	}
?>