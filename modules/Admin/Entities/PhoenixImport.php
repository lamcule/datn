<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 10/16/19
 * Time: 5:54 PM
 */

namespace Modules\Admin\Entities;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\Mon\Entities\Phoenix;
use Modules\Mon\Entities\Province;

class PhoenixImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Phoenix|null
     */
    public function model(array $row)
    {
        return new Phoenix([
            'name'     => $row[1],

        ]);
    }
}
