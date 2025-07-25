<?php

namespace App\Http\Controllers\Client;

use App\DataTables\ClientDataTable;
use App\DataTables\TotalMonthlyAdminCollectedFee;
use App\Events\NewClientCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientEditRequest;
use App\Http\Requests\ClientRequest;
use App\Models\AdminFee;
use App\Models\Cases;
use App\Models\Client;
use App\Models\Installment;
use App\Models\Role;
use App\Models\User;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


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
        $employees = User::where('user_type', 'employee')->get();
        return view('admin.clients.create', compact('roles', 'employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), ['name' => 'required', 'abbr' => 'required|max:3|min:3']);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ]);
        }
        $user = new User();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password =  Hash::make("12345678");   // 12345678;
        $user->save();

        if ($user) {
            $data = $request->all();
            $data['user_id'] = $user->id;

            $client = Client::create($data);

            if ($user) {
                $admin_fee_paid = new AdminFee();
                $admin_fee_paid->admin_fee_amount = $request->admin_fee_paid;
                $admin_fee_paid->client_id = $client->id;
                $admin_fee_paid->collection_date = date('Y-m-d H:i:s');
                $admin_fee_paid->collected_by_id = $request->collected_by_id == null ? 2 : $request->collected_by_id;
                $admin_fee_paid->save();

//                $client->client_id = $user->id;
                $client->user_id = $user->id;
                $client->save();
            }
            if ($client) {
                $data = [
                    'status' => 200,
                    'success' => 'Data Fetched Successfully',
                    'result' =>  $client,
                ];
                event(new NewClientCreated($client));
                return response()->json($data);
            } else {
                $data = [
                    'status' => 500,
                    'success' => 'Something Went Wrong',
                    'result' =>  [],
                ];
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        set_page_meta('Client Details');
        $client = Client::find($id);
        $employees = User::where('user_type', 'employee')->get();
        $cases = Cases::where('client_id', $client->client_id)->get();
        return view('admin.clients.show', compact('client', 'cases', 'employees'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::find($id);
        $employees = User::where('user_type', 'employee')->get();
        return view('admin.clients.edit', compact('client', 'employees'));
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
            $client = Client::find($id);
            $case = Cases::where('client_id', $client->client_id);
            $case->delete();
            $this->clientService->delete($id);
            record_deleted_flash();
            return back();
        } catch (\Exception $e) {
            return back();
        }
    }
    public function printableClientAgreement($id)
    {
        $client_details = Client::find($id);
        return view('admin.agreement.client-agreement', compact('client_details'));
    }
    public function updateAdminFee(Request $request, $id)
    {
        $request->validate([
            'admin_fee_paid' => 'required',
            'client_id' => 'required',
            'collection_date' => 'required',
            'collected_by_id' => 'nullable'
        ]);
        $fee = AdminFee::create(
            [
                'admin_fee_amount' => $request->admin_fee_paid,
                'collection_date' => $request->collection_date,
                'client_id' => $request->client_id,
                'collected_by_id' => $request->collected_by_id == null ? 2 : $request->collected_by_id,
            ]
        );
        if ($fee) {
            $client = Client::where('id', $request->client_id)->first();
            $client->admin_fee_balance = $client->admin_fee_balance - $request->admin_fee_paid;
            $client->admin_fee_paid = $client->admin_fee_paid + $request->admin_fee_paid;
            $client->save();
        }
        record_created_flash();
        return redirect()->route('admin.clients.show', $id);
    }
}
