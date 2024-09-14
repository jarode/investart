<?php

namespace App\Models;

use App\Constants\Status;
use App\Traits\Searchable;
use App\Traits\UserNotify;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Searchable, UserNotify;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'ver_code', 'balance', 'kyc_data'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address'           => 'object',
        'kyc_data'          => 'object',
        'ckv_data'         => 'object',
        'ver_code_send_at'  => 'datetime'
    ];


    public function loginLogs()
    {
        return $this->hasMany(UserLogin::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class)->orderBy('id', 'desc');
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class)->where('status', '!=', Status::PAYMENT_INITIATE);
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'ref_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'ref_by');
    }

    public function activeReferrals()
    {
        return $this->hasMany(User::class, 'ref_by')->whereHas('invests');
    }

    public function allReferrals()
    {
        return $this->referrals()->with('referrer','allReferrals');
    }

    public function cases()
    {
        return $this->hasMany(InvestmentCase::class);
    }

    public function invest()
    {
        return $this->hasMany(Invest::class);
    }

    public function successfulInvest()
    {
        return $this->hasMany(Invest::class,'from_user')->where('status',Status::INVEST_COMPLETED);
    }

    public function tickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function profit()
    {
        return $this->hasMany(ProfitReturn::class, 'to_user')->where('status', Status::RETURN_PROFIT_COMPLETE);
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, InvestmentCase::class, 'user_id', 'case_id');
    }

    public function comments()
    {
        return $this->hasManyThrough(Comment::class, InvestmentCase::class, 'user_id', 'case_id');
    }

    public function fullname(): Attribute
    {
        return new Attribute(
            get: fn () => $this->firstname . ' ' . $this->lastname,
        );
    }

    // SCOPES
    public function scopeActive($query)
    {
        return $query->where('status', Status::USER_ACTIVE)->where('ev', Status::VERIFIED)->where('sv', Status::VERIFIED);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', Status::USER_BAN);
    }

    public function scopeEmailUnverified($query)
    {
        return $query->where('ev', Status::UNVERIFIED);
    }

    public function scopeMobileUnverified($query)
    {
        return $query->where('sv', Status::UNVERIFIED);
    }

    public function scopeKycUnverified($query)
    {
        return $query->where('kv', Status::KYC_UNVERIFIED);
    }

    public function scopeKycPending($query)
    {
        return $query->where('kv', Status::KYC_PENDING);
    }

    public function scopeCkycUnverified($query)
    {
        return $query->where('ckv', Status::KYC_UNVERIFIED);
    }

    public function scopeCkycPending($query)
    {
        return $query->where('ckv', Status::KYC_PENDING);
    }

    public function scopeEmailVerified($query)
    {
        return $query->where('ev', Status::VERIFIED);
    }

    public function scopeMobileVerified($query)
    {
        return $query->where('sv', Status::VERIFIED);
    }

    public function scopeWithBalance($query)
    {
        return $query->where('balance', '>', 0);
    }
}
