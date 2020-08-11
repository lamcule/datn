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
use Modules\Mon\Entities\Province;

class ProvinceImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Province|null
     */
    public function model(array $row)
    {
        return new Province([
            'name'     => $row[1],

        ]);
    }
}
