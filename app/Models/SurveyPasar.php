<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyPasar extends Model
{
    protected $table = 'survey_pasar';

    public function mrdo()
    {
        return $this->belongsTo(MasterRuteDetailOutlet::class, 'survey_pasar_id');
    }
    public function mco()
    {
        return $this->hasMany(MasterConvertOutlet::class, 'id_outlet_mas');
    }
    public function mp()
    {
        return $this->belongsTo(MasterPasar::class, 'id_pasar', 'id_pasar');
    }
    public function w()
    {
        return $this->belongsTo(Wilayah::class, 'id_wilayah', 'id_wilayah');
    }
    public function d()
    {
        return $this->belongsTo(Distributor::class, 'id_distributor', 'id_distributor');
    }
}
