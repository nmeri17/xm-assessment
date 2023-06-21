<?php
	namespace AllModules\CompanySymbol\Tests\Exceptions;

	use Suphle\Hydration\Container;

	use Suphle\Contracts\Modules\DescriptorInterface;

	use Suphle\Testing\{TestTypes\InvestigateSystemCrash, Utilities\PingHttpServer};

	use AllModules\CompanySymbol\Meta\CompanySymbolDescriptor;

	class ServerBuildTest extends InvestigateSystemCrash {

		use PingHttpServer;

		protected function getModule ():DescriptorInterface {

			return new CompanySymbolDescriptor(new Container);
		}

		public function test_server_builds_successfully () {

			$this->assertServerBuilds();
		}
	}
?>