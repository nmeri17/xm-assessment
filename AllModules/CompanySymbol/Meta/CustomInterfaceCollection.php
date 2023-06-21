<?php
	namespace AllModules\CompanySymbol\Meta;

	use Suphle\Hydration\Structures\BaseInterfaceCollection;

	use Suphle\Contracts\{Config\Router, Auth\UserContract};

	use AllModules\CompanySymbol\Config\RouterMock;

	use AppModels\User as EloquentUser; // hard-coded cuz different processes control module cloning and component ejection

	use ModuleInteractions\CompanySymbol;

	class CustomInterfaceCollection extends BaseInterfaceCollection {

		public function getConfigs ():array {
			
			return array_merge(parent::getConfigs(), [

				Router::class => RouterMock::class
			]);
		}

		public function simpleBinds ():array {

			return array_merge(parent::simpleBinds(), [

				CompanySymbol::class => ModuleApi::class,

				UserContract::class => EloquentUser::class
			]);
		}
	}
?>