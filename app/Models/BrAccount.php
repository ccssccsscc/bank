<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrAccount extends Model
{
    protected $guarded = false;
    
    protected $table ='br_accounts';
    use HasFactory;
}
