<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRute extends Model
{
    protected $table = 'master_rute';
    public $timestamps = false;

    public function mrdo()
    {
        return $this->hasMany(MasterRuteDetailOutlet::class, 'rute_id');
    }
    public function d()
    {
        return $this->hasOne(Distributor::class, 'id_distributor', 'id_distributor');
    }
    public function w()
    {
        return $this->hasOne(Wilayah::class, 'id_wilayah', 'id_wilayah');
    }

    public function kr()
    {
        return $this->hasOne(Karyawan::class, 'nama', 'salesman');
    }
}
