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
}
