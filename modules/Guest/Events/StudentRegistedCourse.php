<?php

namespace Modules\Guest\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\User;

class StudentRegistedCourse
{
    use SerializesModels;
    /** @var User */
    public $user;
    /** @var Grade */
    public $grade;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Grade $grade)
    {
        $this->grade = $grade;
        $this->user = $user;
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
