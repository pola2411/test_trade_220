<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawn extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function status(){
        return $this->belongsTo(statusWithdrawn::class,'status_id'); // Adjust Status::class to the actual class name if different

    }
    public function approved_by(){
        return $this->belongsTo(User::class,'approved_by');
    }
    public function account_bank(){
        return $this->belongsTo(BankAccounts::class,'account_bank_id');
    }


}
