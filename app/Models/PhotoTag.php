<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoTag extends Model
{
    use HasFactory;

    protected $table    = 'photo_tags';
    protected $fillable = [ 
      'id',
      'photo_id',
      'tag_id',
      'created_at',
      'updated_at'
    ];

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
