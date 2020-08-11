<?php

namespace Modules\Admin\Console;

use Illuminate\Console\Command;

use Modules\Mon\Entities\Profile;
use Modules\Mon\Entities\User;
use Modules\Mon\Repositories\PermissionRepository;
use Modules\Mon\Repositories\ProfileRepository;
use Modules\Mon\Repositories\UserRepository;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UpdateProfile extends Command {
	/**
	 * The console command name.
	 * php artisan admin:create-root-user email password
	 * @var string
	 */
	protected $name = 'admin:update-profile';

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

        $profiles = Profile::query()->get();
		foreach ($profiles as $profile) {
            if (in_array($profile->id,[15,171,172,173,174,175,176,178,180,181,182,183,184,185,186,187,188,191,346,458]) || ($profile->id>=424 && $profile->id<=446) || ($profile->id>=473 && $profile->id<=491)){
                $categories = $profile->categories;
                $personal_categories = $profile->personal_categories;
                $profile->categories = $personal_categories;
                $profile->personal_categories = $categories;
                $profile->save();
            }


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
