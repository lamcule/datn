<?php

namespace Modules\Admin\Console;

use Illuminate\Console\Command;

use Modules\Mon\Entities\User;
use Modules\Mon\Repositories\PermissionRepository;
use Modules\Mon\Repositories\UserRepository;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CreateStudent extends Command
{
    /**
     * The console command name.
     * php artisan admin:create-root-user email password
     * @var string
     */
    protected $name = 'admin:create_student';

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
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * @var $userRepository UserRepository
         */
        $userRepository = app(UserRepository::class);
        for($i=0; $i< 10;$i++) {
            $email = str_random(10).'@gmail.com';
            $password =   ('123456');

            $existEmail = $userRepository->findByAttributes(['email'=> $email]);
            if ($existEmail) {
                $this->error("Email exists");
                return false;
            }

            /** @var User $user */
            $user = $userRepository->create([
                'name' => 'Student '.str_random(10),
                'username' => $email,
                'email' => $email,
                'type' => User::TYPE_STUDENT,
//            'email_verified_at' => now(),
                'password' => \Hash::make($password), // secret
                'remember_token' => str_random(10),
            ]);
        }



    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [

        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
        ];
    }

}
