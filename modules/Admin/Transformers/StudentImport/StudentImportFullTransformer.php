<?php

namespace Modules\Admin\Transformers\StudentImport;

use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Profile\ProfileTransformer;


class StudentImportFullTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'path' => $this->path,
            'status' => $this->status,
            'records' => $this->records,

            'created_at' => optional($this->created_at)->format('d-m-Y H:i:s'),
            'updated_at' =>optional($this->updated_at)->format('d-m-Y'),

            'urls' => [
                'delete_url' => route('api.studentimport.destroy', $this->id),
            ],
        ];


        return $data;
    }


}
