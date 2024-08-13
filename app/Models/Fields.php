<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fields extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function type(){
        return $this->belongsTo(FieldsType::class,'fields_type');
    }
}
