<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id', 'id');
    }
    public function scopeWhenStatus($q, $status)
    {
        return $q->when($status, function ($q) use ($status) {
            if($status=='pending') {
                return $q->whereDate('date','<', now()->toDateString());
            } elseif($status=='accepted') {
                return $q->whereDate('date','>', 'accepted')->where('status', '!=','canceled');
            }  elseif($status=='canceled') {
                return $q->whereDate('status', 'canceled');
            }
        });
    }

    public function getReservationStatusAttribute($value)
    {

        if($this->status=='pending' && $this->date > now()->toDateString()) {
            return 'قيد الانتظار';
        } elseif($this->status=='pending' || $this->status=='accepted' || ($this->status!='canceled' && $this->date < now()->toDateString())) {
            return 'مقبول';
        } elseif($this->status=='canceled') {
            return 'ملغي';
        }
    }
}
