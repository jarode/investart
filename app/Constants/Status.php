<?php

namespace App\Constants;

class Status
{

    const ENABLE = 1;
    const DISABLE = 0;

    const YES = 1;
    const NO = 0;

    const VERIFIED = 1;
    const UNVERIFIED = 0;

    const PAYMENT_INITIATE = 0;
    const PAYMENT_SUCCESS = 1;
    const PAYMENT_PENDING = 2;
    const PAYMENT_REJECT = 3;

    const TICKET_OPEN = 0;
    const TICKET_ANSWER = 1;
    const TICKET_REPLY = 2;
    const TICKET_CLOSE = 3;

    const PRIORITY_LOW = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH = 3;

    const USER_ACTIVE = 1;
    const USER_BAN = 0;

    const KYC_UNVERIFIED = 0;
    const KYC_PENDING = 2;
    const KYC_VERIFIED = 1;

    const FIXED_TYPE = 1;
    const PERCENTAGE_TYPE = 0;

    const CAPITAL_BACK_YES = 1;
    const CAPITAL_BACK_NO = 0;

    const RETURN_PROFIT_INCOMPLETE = 0;
    const RETURN_PROFIT_COMPLETE = 1;


    const CASE_PENDING  = 0;
    const CASE_APPROVE  = 1;
    const CASE_DRAFT    = 2;
    const CASE_REACHED  = 3;
    const CASE_REJECTED = 4;

    const INVEST_RUNNING   = 2;
    const INVEST_COMPLETED = 1;

    const BADGE_ACTIVE = 1;
    const BADGE_INACTIVE = 0;

    const APPROVED = 1;
    const PENDING = 0;
}
