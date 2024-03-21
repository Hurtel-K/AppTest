<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;

    protected $guarded = [];   

    
    protected $keyType = 'string';


    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function($like){

            $like->likeable_id = (string) Str::uuid();
        });
    }


    public function likeable()
    {
        return $this->morphTo();
    }


}
