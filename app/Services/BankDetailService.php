<?php

namespace App\Services;


use App\Models\BankDetail;
use App\Services\BaseService;

class BankDetailService extends BaseService
{

    protected $model;

    public function __construct()
    {
        $this->model = BankDetail::class;
    }

    public function storeOrUpdate($data, $id = null)
    {
        try {
            // manage additional data
            return parent::storeOrUpdate($data, $id);
        } catch (\Exception $e) {
            $this->logFlashThrow($e);
        }
    }
}

