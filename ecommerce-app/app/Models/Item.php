<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['item_name','image',"category_id","price","description"];

    public function category(){
        return $this->belongsTo(Category::class);
    }

}
