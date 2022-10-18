<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Plan extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name', 'description'];

    protected $guarded = [];


    public function extension_until()
    {
        return [
            '1' => Carbon::now()->addMonth(),
            '2' => Carbon::now()->addMonths(6),
            '3' => Carbon::now()->addYear(),
        ][$this->type];
    }
}
