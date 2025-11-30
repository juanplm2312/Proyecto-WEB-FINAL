<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gift extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'creator_id',
        'title',
        'description',
        'suggested_price',
        'image_path'
    ];

    /** 
     * Creador del regalo (User)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Intercambios donde este regalo fue usado
     */
    public function exchanges()
    {
        return $this->hasMany(Exchange::class, 'gift_id');
    }

    /**
     * Usuarios que lo tienen en wishlist (pivot gift_user)
     */
    public function wishedBy()
    {
        return $this->belongsToMany(User::class, 'gift_user', 'gift_id', 'user_id')
            ->withTimestamps();
    }
}
