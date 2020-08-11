<?php
namespace Modules\Admin\Transformers\ImportDetail;
use Illuminate\Http\Resources\Json\Resource;
use Modules\Admin\Transformers\Profile\ProfileTransformer;


class ImportDetailFullTransformer extends Resource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'import_id' => $this->import_id,
            'content' => $this->content,
            'status' => $this->status,
            'imported_at' => $this->imported_at,
            'imported_description' => $this->imported_description,

            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,

            'created_at' => optional($this->created_at)->format('d-m-Y H:i:s'),
            'updated_at' =>optional($this->updated_at)->format('d-m-Y'),

            'urls' => [
                'delete_url' => route('api.importdetail.destroy', $this->id),
            ],
        ];


        return $data;
    }

}
