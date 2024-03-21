<?php

namespace App\Models;

use App\Models\Like;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Beat extends Model
{
    use HasFactory;   

    protected $guarded = [];

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    protected static function booted()
    {
        static::creating(function($beat){

            $beat->id = (string) Str::uuid();
        });
    }

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }



}
