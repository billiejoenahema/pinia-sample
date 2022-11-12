<?php

namespace App\Models;

use App\Enums\Prefecture;
use App\Http\Requests\User\IndexRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /** 集計する日数 */
    public const TOTAL_DAYS = 3;

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
     * 所有する勤怠情報を取得する。
     *
     * @return HasMany
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
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
        $searchWord = $request['search_word'] ?? null;
        if ($searchWord) {
            $query->where($request['search_column'], 'like', "%{$searchWord}%");
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

    /**
     * 都道府県名を操作
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function pref(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Prefecture::from($value)->text(),
        );
    }

    /**
     * 郵便番号を操作
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function zipcode(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $code1 = substr($value, 0, 3);
                $code2 = substr($value, 3);
                return "{$code1}-{$code2}";
            },
        );
    }

    /**
     * 過去n日間の総労働時間を'H:i'形式で取得する
     *
     * @return string
     */
    public function getTotalWorkingTimeAttribute(): string
    {
        /** @var \App\Models\User $this */
        $attendances = $this->attendances->take(self::TOTAL_DAYS);
        $workingTimes = collect($attendances)->map(function ($item) {
            $inTime = strtotime($item->in_time);
            $outTime = strtotime($item->out_time);
            $restTime = strtotime($item->rest_time) - strtotime('00:00');

            return $outTime - $inTime - $restTime;
        });
        // 総労働時間の秒数
        $sec = $workingTimes->sum();
        // 時
        $hours = floor($sec / 3600);
        // 分
        $minutes = floor(($sec / 60) % 60);

        return sprintf("%2d:%02d", $hours, $minutes);
    }
}
