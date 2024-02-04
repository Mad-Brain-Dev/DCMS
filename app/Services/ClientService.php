<?php

namespace App\Services;

use App\Models\Client;
use App\Services\BaseService;

class ClientService extends BaseService
{

    protected $model;

    public function __construct()
    {
        $this->model = Client::class;
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

