<?php

namespace Modules\Admin\Console;

use Illuminate\Console\Command;

use Modules\Mon\Entities\Profile;
use Modules\Mon\Entities\User;
use Modules\Mon\Repositories\PermissionRepository;
use Modules\Mon\Repositories\UserRepository;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateStudent extends Command {
	/**
	 * The console command name.
	 * php artisan admin:create-root-user email password
	 * @var string
	 */
	protected $name = 'admin:update_student';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';


	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {
		/**
		 * @var $userRepository UserRepository
		 */
		$userRepository = app(UserRepository::class);
		$users = User::with('profile')->get();
		foreach ($users as $user) {


			$profile = Profile::query()->where('user_id', $user->id)->first();
			if ($profile) {
				$user->name = $profile->first_name . ' ' . $profile->last_name;
				$profile->full_name = $profile->first_name . ' ' . $profile->last_name;
				$profile->save();
			}
			$user->save();


		}


	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments() {
		return [

		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions() {
		return [
		];
	}

}
