<?php

namespace App\Models;

use App\Http\Requests\User\IndexRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name 名前
 * @property string $email メールアドレス
 * @property string|null $phone 電話番号
 * @property string|null $zipcode 郵便番号
 * @property string|null $pref 都道府県
 * @property string|null $city 市区町村
 * @property string|null $street 番地
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePref($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereZipcode($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|User searchCondition($data)
 * @method static \Illuminate\Database\Eloquent\Builder|User sortByColumn($column, $order)
 * @method static \Illuminate\Database\Eloquent\Builder|User sortByIdDesc()
 * @property-read \App\Models\Partner|null $user
 * @method static Builder|User addSearchCondition($request)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'zipcode',
        'pref',
        'city',
        'street',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * 所有するパートナーを取得する。
     *
     * @return HasOne
     */
    public function partner(): HasOne
    {
        return $this->hasOne(Partner::class);
    }

    /**
     * IDの降順でソートするスコープ
     *
     * @param Builder|User $query
     * @return Builder|User
     */
    public function scopeSortByIdDesc($query): Builder|User
    {
        $query->orderBy('id', 'desc');

        return $query;
    }

    /**
     * 検索条件
     *
     * @param Builder|User $query
     * @param IndexRequest $request
     * @return Builder|User
     */
    public function scopeAddSearchCondition($query, $request): Builder|User
    {
        if (isset($request['name'])) {
            $query->where('name', 'like', "%{$request['name']}%");
        }
        if (isset($request['email'])) {
            $query->where('email', 'like', "%{$request['email']}%");
        }
        if (isset($request['phone'])) {
            $query->where('phone', 'like', "%{$request['phone']}%");
        }

        return $query;
    }

    /**
     * 指定のカラムでソートするスコープ
     *
     * @param Builder|User $query
     * @param string $column
     * @param string $direction
     * @return Builder|User
     */
    public function scopeSortByColumn($query, $column, $direction): Builder|User
    {
        // 検索対象のカラム
        $columns = [
            'name',
            'email',
            'phone',
        ];
        if (in_array($column, $columns, false)) {
            $query->orderBy($column, $direction);
        }

        return $query;
    }
}
