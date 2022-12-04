<?php

namespace App\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

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

    public function getImageAttribute($value)
    {

        return $value ? asset('storage/' . $value) : null;
    }

    public function isLawyer()
    {
        return $this->type == 'lawyer' || $this->type == 'office';
    }

    public function type_of_lawyer()
    {

        return $this->belongsTo(LawyerType::class, 'lawyer_type', 'id');
    }


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function working_hours()
    {
        return $this->hasMany(WorkingHours::class, 'lawyer_id', 'id');
    }

    public function scopeWhenName($query, $name)
    {
        return $query->when($name, function ($q) use ($name) {
            return $q->where('name', 'like', '%' . $name . '%');
        });
    }

    public function scopeWhenCity($query, $city_id)
    {
        return $query->when($city_id, function ($q) use ($city_id) {
            return $q->where('city_id', $city_id);
        });
    }

    public function scopeWhenId($query, $id)
    {

        return $query->when($id, function ($q) use ($id) {
            return $q->where('id', $id);
        });
    }

    public function scopeWhenTypeOfLawyer($query, $type)
    {
        DB::listen(function ($query) {
            Log::info($query->sql, $query->bindings);
        });
        return $query->when($type, function ($q) use ($type) {
            $q->where(function ($q) use ($type) {
                $q->whereHas('type_of_lawyer', function ($q) use ($type) {
                    $q->where('id', $type);
                })->orWhereHas('office_type', function ($q) use ($type) {
                    $q->whereColumn('users.id', '=', 'lawyer_office_type.lawyer_id')
                        ->where('lawyer_office_type.type_id', $type);
                });
            });
        });
    }

    public function office_type()
    {

        return $this->belongsToMany(LawyerType::class, 'lawyer_office_type', 'lawyer_id', 'type_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'user_id', 'id');
    }

    public function scopeWhereLawyerEnabled($q)
    {
        return $q->whereDate('enabled_to','>',now()->toDateString())->where('enabled', 1);
    }



    public function review(){
        return $this->hasMany(Review::class, 'lawyer_id', 'id');
    }

}
