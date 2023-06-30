<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRuteDetailOutlet extends Model
{
    protected $table = 'master_rute_detail_outlet';
    // protected $fillable = ['survey_pasar_id', 'alamat'];
    public $timestamps = false;

    public function mr()
    {
        return $this->belongsTo(MasterRute::class, 'rute_id');
    }

    public function mrd()
    {
        return $this->belongsTo(MasterRuteDetail::class, 'rute_detail_id');
    }

    public function mco()
    {
        return $this->hasMany(MasterConvertOutlet::class, 'id_outlet_mas', 'survey_pasar_id');
    }
    public function mp()
    {
        return $this->belongsTo(MasterPasar::class, 'id_pasar', 'id_pasar');
    }
}
