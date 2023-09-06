<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at']; /* hidden field created_at & updated_at */
    protected $appends = ['stored_at']; /* menambah attribute yg tidak ada di dalam table/alias  */

    public function getStoredAtAttribute() /*  get{NamaAtribut}Attribute, Laravel akan menganggap metode tersebut sebagai accessor untuk atribut dengan nama tersebut. */
    {
        return $this->created_at->diffForHumans();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
