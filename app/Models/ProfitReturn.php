<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;

class ProfitReturn extends Model
{
    use GlobalStatus, Searchable;

    function invest()
    {
        return $this->belongsTo(Invest::class);
    }

    function user()
    {
        return $this->belongsTo(User::class, 'to_user');
    }
}
