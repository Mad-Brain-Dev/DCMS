<?php

namespace App\Services;


use App\Models\User;
use App\Models\Cases;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Str;
use App\Services\BaseService;

class CaseService extends BaseService
{

    protected $model;

    public function __construct()
    {
        $this->model = Cases::class;
    }

    public function storeOrUpdate($data, $id = null)
    {
        try {
            // manage additional data
            // $data['user_type'] = 'client';
            return parent::storeOrUpdate($data, $id);
        } catch (\Exception $e) {
            $this->logFlashThrow($e);
        }
    }
}

