<?php
	namespace AllModules\CompanySymbol\Tests\Exceptions;

	use Suphle\Contracts\Modules\DescriptorInterface;

	use Suphle\Hydration\Container;

	use Suphle\Exception\Diffusers\GenericDiffuser;

	use Suphle\Testing\TestTypes\InvestigateSystemCrash;

	use AllModules\CompanySymbol\Meta\CompanySymbolDescriptor;

	use Exception;

	class GracefulShutdownTest extends InvestigateSystemCrash {

		public function getModule ():DescriptorInterface {

			return new CompanySymbolDescriptor(new Container);
		}

		public function test_graceful_shutdown_successful () {

			$exceptionDetails = \Wyrihaximus\throwable_json_encode(new Exception); // given

			$renderer = $this->getContainer()->getClass(self::BRIDGE_NAME)

			->gracefulShutdown($exceptionDetails); // when

			$this->assertTrue(

				$renderer->matchesHandler(GenericDiffuser::CONTROLLER_ACTION)
			); // then
		}
	}
?>