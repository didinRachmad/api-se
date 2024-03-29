<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'karyawan';

    public function w()
    {
        return $this->hasOne(Wilayah::class, 'id_wilayah', 'iddepo');
    }
}
