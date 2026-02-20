<?php

namespace App\Utils;

class GlobalConstant
{
    // Status
    public const STATUS_ACTIVE    = 'active';
    public const STATUS_INACTIVE  = 'inactive';
    public const STATUS_PENDING   = 'pending';
    public const STATUS_DRAFT     = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_CANCELED  = 'canceled';
    public const STATUS_PAID      = 'paid';
    public const STATUS_UNPAID    = 'unpaid';
    public const STATUS_REJECTED  = 'rejected';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_ACCEPTED  = 'accepted';
    public const STATUS_ENROLLED  = 'enrolled';

    //Case Status

    public const CASE_PENDING = 'PDG';
    public const CASE_OPEN = 'OPN';
    public const CASE_FIELD  = 'FLD';
    public const  CASE_DESPATCHED = 'DSP';
    public const CASE_INVESTIGATION_NEEDED = 'INV';
    public const CASE_NEGOTIATING_WITH_DB = 'NGD';
    public const CASE_UNDER_INSTALMENT = 'INS';
    public const CASE_FULLY_SETTELED = 'FST';
    public const CASE_PARTIALLY_SETTELED = 'PST';
    public const CASE_CASE_ON_HOLD_BY_CLIENT = 'OHC';
    public const CASE_ON_HOLD_BY_MANAGEMENT = 'OHM';
    public const CASE_CLOSED_WITHOUT_PAYMENT = 'CST';
    public const CASE_AWAITING_UPDATE_FR_CLIENT = 'AFC';
    public const CASE_UNDER_LITIGATION = 'ULT';
    public const CASE_CLOSED = 'cls';

    // Default
    public const DEFAULT_PER_PAGE     = 12;
    public const DEFAULT_RECENT_LIMIT = 5;
    public const DEFAULT_THUMB_WIDTH  = 300;
    public const DEFAULT_THUMB_HEIGHT = 170;
    public const DEFAULT_QR_CODE_SIZE = 300;

}

