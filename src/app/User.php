<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property int $id
 * @property string $external_id
 * @property string|null $refresh_token
 * @property string|null $token_expires_at
 * @property string $nickname
 * @property string $avatar
 * @property string|null $email
 * @property int $admin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereExternalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTokenExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{

    public static function getFromSteam(\Laravel\Socialite\Two\User $user)
    {
        $localUser = self::whereExternalId($user->id)->first();
        if (!$localUser) {
            $localUser = new User;
            $localUser->external_id = $user->id;
        }
        $localUser->email = $user->email;
        $localUser->avatar = $user->avatar;
        $localUser->nickname = $user->nickname;
        $localUser->save();
        return $localUser;
    }
}
