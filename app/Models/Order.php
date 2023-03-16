<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'order';

    public function art()
    {
        return $this->belongsTo(Artransaction::class, 'document', 'document');
    }
}
