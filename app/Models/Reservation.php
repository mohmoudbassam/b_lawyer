<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id', 'id');
    }
    public function scopeWhenStatus($q, $status)
    {

        return $q->when($status, function ($q) use ($status) {
            if($status=='pending') {
                return $q->where('status','=','pending');
            } elseif($status=='accepted') {
                return $q->where('status', '=','ended');
            }  elseif($status=='canceled') {
                return $q->where('status', 'canceled');
            }
        });
    }

    public function getReservationStatusAttribute($value)
    {

        if($this->status=='pending') {
            return 'قيد الانتظار';
        } elseif($this->status=='pending' || $this->status=='ended' || ($this->status!='canceled' && $this->date < now()->toDateString())) {
            return 'منتهيه';
        } elseif($this->status=='canceled') {
            return 'ملغي';
        }
    }
}
