<?php

namespace Modules\Admin\Events\Lesson;

use Modules\Media\Repositories\StoringMedia;
use Modules\Core\Entities\News;
use Modules\Mon\Entities\Lesson;


class LessonWasCreated implements StoringMedia
{
    /**
     * @var Lesson
     */
    private $model;
    private $data;
    public function __construct(Lesson $model, $data)
    {
        $this->model = $model;
        $this->data = $data;
    }
    /**
     * Return the entity
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getEntity()
    {
        return $this->model;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData()
    {
        return $this->data;
    }
    public function getEntityText()
    {
        return 'lesson';
    }
}
