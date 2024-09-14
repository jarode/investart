<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\Searchable;

class Invest extends Model
{
    use Searchable;

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function case()
    {
        return $this->belongsTo(InvestmentCase::class);
    }

    function plan()
    {
        return $this->belongsTo(InvestmentPlan::class, 'case_type_id');
    }

    public function profits()
    {
        return $this->hasMany(ProfitReturn::class, 'invest_id')->where('status', Status::ENABLE);
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::INVEST_COMPLETED) {
                $html = '<span class="badge custom--badge badge--success">' . trans('Completed') . '</span>';
            } else {
                $html = '<span class="badge custom--badge badge--warning">' . trans('Running') . '</span>';
            }
            return $html;
        });
    }
}
