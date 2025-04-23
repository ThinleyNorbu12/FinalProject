<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InspectionDecision extends Model
{
    protected $fillable = ['inspection_request_id', 'decision',  'admin_id'];

    public function inspectionRequest()
    {
        return $this->belongsTo(InspectionRequest::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

}
