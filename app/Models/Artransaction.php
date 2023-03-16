<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artransaction extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'artransaction';

    public function o()
    {
        return $this->hasMany(Order::class, 'document', 'document');
    }

    public function ar()
    {
        return $this->belongsTo(Dataar::class, 'dataar');
    }
}
