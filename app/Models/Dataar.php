<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dataar extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'dataar';

    public function art()
    {
        return $this->hasOne(Artransaction::class, 'dataar');
    }
}
