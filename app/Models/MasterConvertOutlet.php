<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterConvertOutlet extends Model
{
    protected $table = 'master_convert_outlet';
    protected $fillable = ['kode_customer'];
    public $timestamps = false;

    public function mrdo()
    {
        return $this->belongsTo(MasterRuteDetailOutlet::class, 'id_outlet_mas', 'survey_pasar_id');
    }
}
