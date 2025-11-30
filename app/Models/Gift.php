<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gift extends Model
{
    use SoftDeletes;

    protected $fillable = ['creator_id','title','description','suggested_price','image_path'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function exchanges()
    {
        return $this->hasMany(Exchange::class);
    }

    public function wishedBy() // many-to-many users wishlist
    {
        return $this->belongsToMany(User::class, 'gift_user')->withTimestamps();
    }
}
