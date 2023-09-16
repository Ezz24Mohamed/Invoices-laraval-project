<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $guarded=[];
    public function section()
    {
        //one to many eloquent relationship (products belong to one section)
        return $this->belongsTo(Section::class);
    }
}