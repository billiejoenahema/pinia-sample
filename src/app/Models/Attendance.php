<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Attendance extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'in_time' => 'datetime: H:i',
        'out_time' => 'datetime: H:i',
        'rest_time' => 'datetime: H:i',
    ];

    /**
     * 労働時間を取得
     *
     * @return string
     */
    public function getWorkingTimeAttribute(): string
    {
        $inTime = strtotime($this->in_time);
        $outTime = strtotime($this->out_time);
        $restTime = strtotime($this->rest_time) - strtotime('00:00');

        return Carbon::parse($outTime - $inTime - $restTime)->format('H:i');
    }
}
