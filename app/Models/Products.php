<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    protected $fillable = [
        'product_name',
        'section_id',
        'description',
        'created_by'
    ];
    use HasFactory;
    public function section()
    {
        return $this->belongsTo(sections::class);
    }

}
