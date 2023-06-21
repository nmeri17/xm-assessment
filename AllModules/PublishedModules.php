<?php
	namespace AllModules;

	use Suphle\Modules\ModuleHandlerIdentifier;

	use Suphle\Hydration\Container;

	use AllModules\CompanySymbol\Meta\CompanySymbolDescriptor;

	class PublishedModules extends ModuleHandlerIdentifier {
		
		/**
		 * @return CompanySymbolDescriptor[]
		 *
		 * @psalm-return list{CompanySymbolDescriptor}
		 */
		public function getModules ():array {

			return [new CompanySymbolDescriptor(new Container)];
		}
	}
?>