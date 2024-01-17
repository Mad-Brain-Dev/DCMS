<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Str;
use App\Services\BaseService;

class DebtorService extends BaseService
{

    protected $model;

    public function __construct()
    {
        $this->model = User::class;
    }

    public function storeOrUpdate($data, $id = null)
    {
        try {
            // manage additional data
            $data['user_type'] = 'debtor';
            return parent::storeOrUpdate($data, $id);
        } catch (\Exception $e) {
            $this->logFlashThrow($e);
        }
    }
}

