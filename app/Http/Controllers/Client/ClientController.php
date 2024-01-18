<?php

namespace App\Http\Controllers\Client;

use App\DataTables\ClientDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientEditRequest;
use App\Http\Requests\ClientRequest;
use App\Models\User;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(ClientDataTable $dataTable)
    {
        set_page_meta('Client');
        return $dataTable->render('admin.clients.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $data = $request->validated();
        try {
            $this->clientService->storeOrUpdate($data, null);
            record_created_flash();

        } catch (\Exception $e) {
        }
        return redirect()->route('admin.clients.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $clients = User::find($id);
        return view('admin.clients.edit', compact('clients'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientEditRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $this->clientService->storeOrUpdate($data, $id);
            record_created_flash();

        } catch (\Exception $e) {
        }
        return redirect()->route('admin.clients.index');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
