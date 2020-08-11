<?php
/**
 * Created by PhpStorm.
 * User: administrator
 * Date: 10/16/19
 * Time: 5:54 PM
 */

namespace Modules\Admin\Entities;

use Maatwebsite\Excel\Concerns\ToModel;
use Modules\Mon\Entities\User;

class MultipleStudentImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        return new User([
            'name'     => $row[1],

        ]);
    }
}
