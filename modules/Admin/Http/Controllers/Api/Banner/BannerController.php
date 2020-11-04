<?php

namespace Modules\Admin\Http\Controllers\Api\Banner;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\Transformers\Banner\BannerFullTransformer;
use Modules\Admin\Transformers\Banner\BannerTransformer;
use Modules\Mon\Entities\Banner;
use Modules\Admin\Http\Requests\Banner\CreateBannerRequest;
use Modules\Admin\Http\Requests\Banner\UpdateBannerRequest;
use Modules\Admin\Repositories\BannerRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class BannerController extends ApiController
{
    /**
     * @var BannerRepository
     */
    private $bannerRepository;

    public function __construct(Authentication $auth, BannerRepository $banner)
    {
        parent::__construct($auth);

        $this->bannerRepository = $banner;
    }


    public function index(Request $request)
    {
        return BannerTransformer::collection($this->bannerRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return BannerTransformer::collection($this->bannerRepository->newQueryBuilder()->get());
    }


    public function store(CreateBannerRequest $request)
    {
        $this->bannerRepository->create($request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::banner.message.create success'),
        ]);
    }


    public function find(Banner $banner)
    {
        return new  BannerFullTransformer($banner);
    }

    public function update(Banner $banner, UpdateBannerRequest $request)
    {
        $this->bannerRepository->update($banner, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::banner.message.update success'),
        ]);
    }

    public function destroy(Banner $banner)
    {
        $this->bannerRepository->destroy($banner);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::banner.message.delete success'),
        ]);
    }

    public function getBannerHome()
    {
        $banners = $this->bannerRepository->newQueryBuilder()->where('status', 'active')
            ->orderBy('position', 'desc')->limit(3)->get();

        return BannerTransformer::collection($banners);
    }
}
