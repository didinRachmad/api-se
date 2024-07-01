<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipOutletToken extends Model
{
    // use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'membership_outlet_token';
}
