<?php
	namespace AppModels;

	use Suphle\Adapters\Orms\Eloquent\Models\User as ParentUser;

	use AppModels\Factories\UserFactory;

	use Illuminate\Database\Eloquent\Factories\Factory;

	class User extends ParentUser {

		public static function migrationFolders ():array {

			return [__DIR__ . DIRECTORY_SEPARATOR . "Migrations"];
		}

		protected static function newFactory ():Factory {

			return UserFactory::new();
		}
	}
?>