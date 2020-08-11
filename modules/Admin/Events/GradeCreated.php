<?php

namespace Modules\Admin\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Mon\Entities\Grade;

class GradeCreated
{
    use SerializesModels;
    /** @var Grade */
    public $grade;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Grade $grade)
    {
        $this->grade = $grade;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
