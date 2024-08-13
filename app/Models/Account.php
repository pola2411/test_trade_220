<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function currancy(){
        return $this->belongsTo(Currancy::class,'currancy_id');
    }

}
