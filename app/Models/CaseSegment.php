<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Constants\Status;
use App\Traits\GlobalStatus;

class CaseSegment extends Model
{
    use GlobalStatus;

    protected $guarded = ['id'];

    function scopeActive()
    {
        return $this->where('status', Status::ENABLE);

    }
}