<?php

namespace App\DataTables;

use App\Models\Cases;
use App\Models\Debtor;
use App\Models\Employee;
use App\Models\Installment;
use App\Models\User;
use App\Utils\GlobalConstant;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Can;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CaseDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        // Load employees ONCE for all rows
        $employees = Employee::where('role', 'Employee')->select('id','name')->orderBy('id')->get();
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($item) use ($employees) {

                // Build <option> list in PHP (no Blade here)
                $employeeOptions = '<option value="" disabled ' . ($item->assigned_to_id == null ? 'selected' : '') . '>Select Employee</option>';

                foreach ($employees as $emp) {
                    $selected = ($item->assigned_to_id !== null && $item->assigned_to_id == $emp->id) ? 'selected' : '';
                    $employeeOptions .= '<option value="' . $emp->id . '" ' . $selected . '>' . e($emp->name) . '</option>';
                }
                $buttons = '';


                if (auth()->user()->can('Edit Case')) {
                    $buttons .= '<a class="dropdown-item" href="' . route('admin.cases.edit', $item->id) . '" title="Edit"><i class="mdi mdi-square-edit-outline"></i> Edit </a>';
                }

                if (auth()->user()->can('Case View')) {
                    $buttons .= '<a class="dropdown-item" href="' . route('admin.cases.show', $item->id) . '" title="Show"><i class="fa fa-eye" aria-hidden="true"></i> Show </a>';
                }
                $buttons .= '<a class="dropdown-item" href="' . route('printable.case.warrant', $item->id) . '" title="Warrant"><i class="fas fa-print"></i> Print Warrant </a>';


                $buttons .= '<a class="dropdown-item" href="' . route('printable.case.letter', $item->id) . '" title="Latter"><i class="fas fa-print"></i> Print Letter </a>';


                $buttons .= '<a class="dropdown-item" href="' . route('cases.debtor.details', $item->id) . '" title="Debtors"><i class="fas fa-paste"></i> Debtor Details </a>';

                // Modal trigger
                $buttons .= '<a class="dropdown-item" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#staticBackdrop-' . $item->id . '">
                            <i class="fas fa-users-cog"></i> Assign Employee
                         </a>';
                    $buttons .= '<form action="' . route('admin.cases.destroy', $item->id) . '"  id="delete-form-' . $item->id . '" method="post" style="">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="dropdown-item text-danger" onclick="return makeDeleteRequest(event, ' . $item->id . ')"  type="submit" title="Delete"><i class="mdi mdi-trash-can-outline"></i> Delete</button></form>
                    ';


                // Dropdown HTML
                $dropdown = '<div class="btn-group dropleft">
                            <a href="#" onclick="return false;" class="btn btn-sm btn-dark text-white dropdown-toggle dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu">' . $buttons . '</div>
                         </div>';

                // Modal HTML (outside dropdown so it renders properly)
                $modal = '
                <div class="modal fade" id="staticBackdrop-' . $item->id . '" data-bs-backdrop="static"
                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel-' . $item->id . '"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel-' . $item->id . '">Assign Employee to case # '.$item->case_sku.'</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="' . route('admin.cases.update.assign.employee') . '" method="post">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="_method" value="POST">
                                <input type="hidden" name="case_id" value="'.$item->id.'">
                                <div class="modal-body">
                                    <div class="mb-3 form-group" style="text-align: left;">
                                        <label class="form-label">Employee <span class="error">*</span></label>
                                        <select name="assigned_to_id" class="form-control">
                                            '.$employeeOptions.'
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';

                // Return both dropdown and modal
                return $dropdown . $modal;
                // })->editColumn('avatar', function ($item) {
                //     return '<img class="ic-img-32" src="' . $item->avatar_url . '" alt="' . $item->last_name . '" />';
            })->editColumn('client_id', function ($item) {
                $name = $item->client->name;
                return $name;
            })
            ->editColumn('name',function ($item){
                return Debtor::where('case_id', $item->id)->firstOrFail()->name;
            })
            ->editColumn('total_amount_owed', function ($item) {
                return number_format($item->total_amount_owed, 2);
            })
            ->editColumn('total_amount_balance', function ($item) {

                return totalBalance($item->id);
            })
            ->editColumn('assigned_to_id', function ($item) {

                if($item->assignedTo){
                    return $item->assignedTo->name;
                }else{
                    return 'Not Assigned yet';
                }
            })
            ->rawColumns(['action', 'avatar', 'status', 'debtor_id', 'total_amount_owed', 'total_amount_balance','assigned_to_id'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Cases $model): QueryBuilder
    {
        return $model->newQuery()->orderBy('id', 'DESC')->select('cases.*');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('case-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->addAction(['width' => '55px', 'class' => 'text-center', 'printable' => false, 'exportable' => false, 'title' => 'Action']);
        //             ->buttons([
        //                        Button::make('excel'),
        //                        Button::make('csv'),
        //                        Button::make('pdf'),
        //                        Button::make('print'),
        //                        Button::make('reset'),
        //                        Button::make('reload')
        //                    ]);

    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            //            Column::computed('DT_RowIndex', 'SL#'),
            Column::make('case_sku', 'case_sku')->title('Case Number'),
            Column::make('name', 'name')->title('Debtor Name'),
            Column::make('total_amount_owed', 'total_amount_owed')->title('Debt Amount'),
            Column::make('total_amount_balance', 'total_amount_balance')->title('Debt Balance'),
            Column::make('assigned_to_id', 'assigned_to_id')->title('Assign To Employee'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Cases_' . date('YmdHis');
    }
}
