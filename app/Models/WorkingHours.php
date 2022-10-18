<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingHours extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'working_hours';

    public function lawyer()
    {
        return $this->belongsTo(User::class, 'lawyer_id', 'id');
    }

}
