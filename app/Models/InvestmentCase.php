<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\GlobalStatus;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;


class InvestmentCase extends Model
{
    use GlobalStatus, Searchable;

    protected $casts = [
        'faq' => 'object'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function plans()
    {
        return $this->hasMany(InvestmentPlan::class, 'case_id')->orderBy('id', 'asc');
    }

    public function activePlan()
    {
        return $this->hasMany(InvestmentPlan::class, 'case_id')->where('status', Status::ENABLE)->orderBy('id', 'asc');
    }

    function comments()
    {
        return $this->hasMany(Comment::class, 'case_id');
    }

    function reviews()
    {
        return $this->hasMany(Review::class, 'case_id');
    }

    public function invests()
    {
        return $this->hasMany(Invest::class, 'case_id');
    }

    public function progress(): Attribute
    {
        return new Attribute(function () {
            return   @$this->goal_amount &&  @$this->goal_amount > 0 ?  ($this->reach_amount / @$this->goal_amount) * 100 : 0;
        });
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::CASE_DRAFT) {
                $html = '<span class="badge custom--badge badge--danger">' . trans('Draft') . '</span>';
            } elseif ($this->status == Status::APPROVED) {
                if ($this->is_approved) {
                    $html = '<span><span class="badge custom--badge badge--success">' . trans('Approved') . '</span>';
                } else {
                    $html = '<span><span class="badge custom--badge badge--success">' . trans('Approved-Disabled') . '</span>';
                }
            } elseif ($this->status == Status::CASE_REACHED) {
                $html = '<span><span class="badge custom--badge badge--success">' . trans('Reached') . '</span>';
            } elseif ($this->status == Status::CASE_REJECTED) {
                $html = '<span><span class="badge custom--badge badge--danger">' . trans('Rejected') . '</span>';
            } else {
                $html = '<span class="badge custom--badge badge--warning">' . trans('Pending') . '</span>';
            }
            return $html;
        });
    }

    public function scopePending($query)
    {
        return $query->where('is_approved', Status::CASE_PENDING)->where('status', Status::CASE_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', Status::CASE_APPROVE);
    }
    public function scopeReached($query)
    {
        return $query->where('status', Status::CASE_REACHED);
    }
    public function scopeRejected($query)
    {
        return $query->where('status', Status::CASE_REJECTED);
    }

    public function scopeValidated($query)
    {
        return $query->where('expired_date', '>=', now());
    }
}
