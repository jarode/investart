<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Constants\Status;
use App\Traits\GlobalStatus;

class Schedule extends Model
{
    use GlobalStatus;
}
