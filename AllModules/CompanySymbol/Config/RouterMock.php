<?php
	namespace AllModules\CompanySymbol\Config;

	use Suphle\Config\Router;

	use AllModules\CompanySymbol\Routes\BrowserCollection;

	class RouterMock extends Router {

		/**
		 * @return string
		 *
		 * @psalm-return BrowserCollection::class
		 */
		public function browserEntryRoute ():?string {

			return BrowserCollection::class;
		}
	}
?>