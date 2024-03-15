<?php

namespace App\Services;


use App\Models\User;
use App\Models\Cases;
use App\Models\Client;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Str;
use App\Services\BaseService;
use Carbon\Carbon;

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
            return parent::storeOrUpdate($data, $id);
        } catch (\Exception $e) {
            $this->logFlashThrow($e);
        }
    }
}

