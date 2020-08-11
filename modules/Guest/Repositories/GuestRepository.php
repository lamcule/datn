<?php
namespace Modules\Guest\Repositories;

use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Lesson;
use Modules\Mon\Entities\User;
use Modules\Mon\Repositories\BaseRepository;

interface GuestRepository extends BaseRepository {
    public function userCheckin(User $user, Lesson $lesson);
    public function userCheckout(User $user, Lesson $lesson);
    public function getUser($username);
    public function registGrade(User $user, Grade $grade, $registered_at= null);
    public function getUserByEmail($email);
    public function storeReview(User $user, Lesson $lesson, $questions);
    public function getQuestionGroup();

}
