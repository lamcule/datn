<?php

namespace Modules\Admin\Console;

use Illuminate\Console\Command;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Entities\DistrictImport;
use Modules\Admin\Entities\PhoenixImport;
use Modules\Admin\Entities\ProvinceImport;
use Modules\Admin\Repositories\DistrictRepository;
use Modules\Admin\Repositories\PhoenixRepository;
use Modules\Admin\Repositories\ProvinceRepository;
use Modules\Mon\Entities\District;
use Modules\Mon\Entities\Phoenix;
use Modules\Mon\Entities\Province;
use Modules\Mon\Entities\User;
use Modules\Mon\Repositories\PermissionRepository;
use Modules\Mon\Repositories\UserRepository;
use Spatie\Permission\Models\Role;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateArea extends Command
{
    /**
     * The console command name.
     * php artisan admin:create-root-user email password
     * @var string
     */
    protected $name = 'admin:insert-area';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert province, district, phoenix.';


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
         * @var $provinceRepository ProvinceRepository
         */
        $provinceRepository = app(ProvinceRepository::class);
        DB::statement("SET foreign_key_checks=0");
        Province::truncate();
        DB::statement("SET foreign_key_checks=1");

        $collection = Excel::toCollection(new ProvinceImport(), base_path('modules/Admin/Console/data/provinces.xlsx'),
            null, \Maatwebsite\Excel\Excel::XLSX);
        $provinces = $collection->first();
        foreach ($provinces as $key => $province) {
            if ($key == 0) {
                continue;
            }
            $provinceRepository->create([
                'code' => $province[0],
                'name' => $province[1],
                'type' => $province[2],
                'phone_code' => $province[3],
            ]);
        }

        // get all province
        $provinceIds = Province::query()->get()->pluck('id', 'code');

        /**
         * @var $districtRepository DistrictRepository
         */
        $districtRepository = app(DistrictRepository::class);
        DB::statement("SET foreign_key_checks=0");
        District::truncate();
        DB::statement("SET foreign_key_checks=1");

        $collection = Excel::toCollection(new DistrictImport(), base_path('modules/Admin/Console/data/districts.xlsx'),
            null, \Maatwebsite\Excel\Excel::XLSX);
        $districts = $collection->first();
        foreach ($districts as $key => $district) {
            if ($key == 0) {
                continue;
            }
            if (!empty($district[3])) {
                list($lat, $lng) = explode(',', $district[3]);
            } else {
                $lat = '';
                $lng = '';
            }

            $province_code = $district[4];
            $province_id = $provinceIds[$province_code];
            $districtRepository->create([
                'code' => $district[0],
                'name' => $district[1],
                'type' => $district[2],
                'lat' => trim($lat),
                'lng' => trim($lng),
                'province_id' => $province_id
            ]);
        }

        // get all district
        $districtIds = District::query()->get()->pluck('id', 'code');
        /**
         * @var $phoenixRepository PhoenixRepository
         */
        $phoenixRepository = app(PhoenixRepository::class);
        DB::statement("SET foreign_key_checks=0");
        Phoenix::truncate();
        DB::statement("SET foreign_key_checks=1");

        $collection = Excel::toCollection(new PhoenixImport(), base_path('modules/Admin/Console/data/phoenix.xlsx'),
            null, \Maatwebsite\Excel\Excel::XLSX);
        /** @var Collection $phoenixes */
        $phoenixes = $collection->first();
        foreach ($phoenixes->chunk(100)  as $phoenixChuck) {
            $recordToInsert =[];
            foreach ($phoenixChuck as $phoenix) {
                if ( !isset($phoenix[0]) || !isset($phoenix[1])  || !isset($phoenix[3]) || !isset($phoenix[4])) {
                    var_dump($phoenix);
                    continue;
                }


                $district_code = $phoenix[4];

                if ( !$districtIds->has($district_code)) {
                    continue;
                }

                $district_id = $districtIds[$district_code];
                $recordToInsert[]= [
                    'code' => $phoenix[0],
                    'name' => $phoenix[1],
                    'type' => $phoenix[3],

                    'district_id' => $district_id
                ];
            }
            Phoenix::insert($recordToInsert);

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
