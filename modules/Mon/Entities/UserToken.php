<?php

namespace Modules\Mon\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Mon\Entities\UserToken
 *
 * @property int $id
 * @property int $user_id
 * @property string $access_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Mon\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserToken whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserToken whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Mon\Entities\UserToken whereUserId($value)
 * @mixin \Eloquent
 */
class UserToken extends Model
{
    protected $table = 'user_tokens';
    protected $fillable = ['user_id', 'access_token'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
