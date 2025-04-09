<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaUpload extends Model
{
    use HasFactory;

    protected $fillable = ['original_name', 'stored_path', 'hash', 'size'];

    protected $casts = [
        'size' => 'integer',
    ];    

}
