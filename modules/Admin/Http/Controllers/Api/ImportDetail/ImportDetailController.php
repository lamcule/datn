<?php

namespace Modules\Admin\Http\Controllers\Api\ImportDetail;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\ImportDetail\ImportDetailTransformer;
use Modules\Mon\Entities\ImportDetail;
use Modules\Admin\Http\Requests\ImportDetail\CreateImportDetailRequest;
use Modules\Admin\Http\Requests\ImportDetail\UpdateImportDetailRequest;
use Modules\Admin\Repositories\ImportDetailRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class ImportDetailController extends ApiController
{
    /**
     * @var ImportDetailRepository
     */
    private $importdetailRepository;

    public function __construct(Authentication $auth, ImportDetailRepository $importdetail)
    {
        parent::__construct($auth);

        $this->importdetailRepository = $importdetail;
    }


    public function index(Request $request)
    {
        return ImportDetailTransformer::collection($this->importdetailRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return ImportDetailTransformer::collection($this->importdetailRepository->newQueryBuilder()->get());
    }


    public function store(CreateImportDetailRequest $request)
    {
        $this->importdetailRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::importdetail.message.create success'),
        ]);
    }


    public function find(ImportDetail $importdetail)
    {
        return new  ImportDetailTransformer($importdetail);
    }

    public function update(ImportDetail $importdetail, UpdateImportDetailRequest $request)
    {
        $this->importdetailRepository->update($importdetail, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::importdetail.message.update success'),
        ]);
    }

    public function destroy(ImportDetail $importdetail)
    {
        $this->importdetailRepository->destroy($importdetail);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::importdetail.message.delete success'),
        ]);
    }
}
