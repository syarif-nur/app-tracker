<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DeliveryOrder extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'delivery_orders';

    protected $fillable = [
        'id',
        'unique_code',
        'creator_id',
        'destination',
        'latitude',
        'longitude',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
            $model->unique_code = self::generateUniqueCode();
        });
    }

    public static function generateUniqueCode()
    {
        $year = date('Y');
        $prefix = 'SJ-' . $year . '-';
        $last = self::where('unique_code', 'like', $prefix . '%')
            ->orderByDesc('unique_code')
            ->first();
        if ($last) {
            $lastNumber = (int)substr($last->unique_code, -4);
            $next = $lastNumber + 1;
        } else {
            $next = 1;
        }
        return $prefix . str_pad($next, 4, '0', STR_PAD_LEFT);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
