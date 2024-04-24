<?php

namespace App\Http\Controllers\Client;

use App\DataTables\ClientDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientEditRequest;
use App\Http\Requests\ClientRequest;
use App\Models\Cases;
use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


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
        set_page_meta('Clients');
        return $dataTable->render('admin.clients.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.clients.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {


        $data = $request->validated();
        try {

            $client = $this->clientService->storeOrUpdate($data, null);

        if($client){
            $user= new User();
            $user->name= $request['name'];
            $user->email= $request['email'];
            $user->password=  Hash::make("12345678");   // 12345678;
            $user->save();
            $client->client_id = $user->id;
            $client->save();
        }
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
        set_page_meta('Client Details');
        $client = Client::find($id);
        $cases = Cases::where('client_id', $client->client_id)->get();
        return view('admin.clients.show', compact('client', 'cases'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::find($id);
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientEditRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $this->clientService->storeOrUpdate($data, $id);
            record_updated_flash();

        } catch (\Exception $e) {
        }
        return redirect()->route('admin.clients.index');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $this->clientService->delete($id);
            record_deleted_flash();
            return back();
        } catch (\Exception $e) {
            return back();
        }
    }

    public function createClient(Request $request)
    {
        $validator = Validator::make($request->all(), [ 'name' => 'required', 'abbr' => 'required' ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }
        $client = Client::create($request->all());
        if($client){
            $user= new User();
            $user->name= $request['name'];
            $user->email= $request['email'];
            $user->password=  Hash::make("12345678");   // 12345678;
            $user->save();
            $client->client_id = $user->id;
            $client->save();
        }

        $data = [
            'status' => 200,
            'success' => 'Data Fetched Successfully',
            'result' =>  $client,
        ];
        return response()->json($data);
    }
}
