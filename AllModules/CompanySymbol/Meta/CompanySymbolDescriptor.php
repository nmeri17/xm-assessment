<?php
	namespace AllModules\CompanySymbol\Meta;

	use Suphle\Modules\ModuleDescriptor;

	use Suphle\Contracts\Config\ModuleFiles;

	use Suphle\Config\AscendingHierarchy;

	use Suphle\File\FileSystemReader;

	use ModuleInteractions\CompanySymbol;

	class CompanySymbolDescriptor extends ModuleDescriptor {

		/**
		 * @return string
		 *
		 * @psalm-return CustomInterfaceCollection::class
		 */
		public function interfaceCollection ():string {

			return CustomInterfaceCollection::class;
		}

		/**
		 * @return string
		 *
		 * @psalm-return CompanySymbol::class
		 */
		public function exportsImplements():string {

			return CompanySymbol::class;
		}

		/**
		 * @return (AscendingHierarchy|mixed)[]
		 *
		 * @psalm-return array{'Suphle\\Contracts\\Config\\ModuleFiles'::class: AscendingHierarchy,...}
		 */
		public function globalConcretes ():array {

			return array_merge(parent::globalConcretes(), [

				ModuleFiles::class => new AscendingHierarchy(
					
					__DIR__, __NAMESPACE__,

					$this->container->getClass(FileSystemReader::class)
				)
			]);
		}

		/**
		 * Remove this method after installation completes. Without components, the illuminate component won't boot and interrupt module creation
		*/
		protected function registerConcreteBindings ():void {

			$bindings = $this->globalConcretes();

			$this->container->whenTypeAny()->needsAny($bindings);
		}
	}
?>