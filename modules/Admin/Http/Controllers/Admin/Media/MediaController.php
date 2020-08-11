<?php

namespace Modules\Admin\Http\Controllers\Admin\Media;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Routing\Controller;
use Modules\Media\Entities\Media;
use Modules\Media\Http\Requests\UpdateMediaRequest;
use Modules\Media\Image\Imagy;
use Modules\Media\Image\ThumbnailManager;
use Modules\Media\Repositories\MediaRepository;

class MediaController extends Controller
{
    /**
     * @var MediaRepository
     */
    private $file;
    /**
     * @var Repository
     */
    private $config;
    /**
     * @var Imagy
     */
    private $imagy;
    /**
     * @var ThumbnailManager
     */
    private $thumbnailsManager;

    public function __construct(MediaRepository $file, Repository $config, Imagy $imagy, ThumbnailManager $thumbnailsManager)
    {

        $this->file = $file;
        $this->config = $config;
        $this->imagy = $imagy;
        $this->thumbnailsManager = $thumbnailsManager;
    }

    public function index() : \Illuminate\View\View
    {
        $config = $this->config->get('asgard.media.config');

        return view('admin::media.admin.index', compact('config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('admin::media.admin.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Media     $file
     * @return Response
     */
    public function edit(Media $file)
    {
        $thumbnails = $this->thumbnailsManager->all();

        return view('admin::media.admin.edit', compact('file', 'thumbnails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Media               $file
     * @param  UpdateMediaRequest $request
     * @return Response
     */
    public function update(Media $file, UpdateMediaRequest $request)
    {
        $this->file->update($file, $request->all());

        return redirect()->route('admin.media.media.index')
            ->withSuccess(trans('media::messages.file updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Media     $file
     * @internal param int $id
     * @return Response
     */
    public function destroy(Media $file)
    {
        $this->imagy->deleteAllFor($file);
        $this->file->destroy($file);

        return redirect()->route('admin.media.media.index')
            ->withSuccess(trans('media::messages.file deleted'));
    }
}
