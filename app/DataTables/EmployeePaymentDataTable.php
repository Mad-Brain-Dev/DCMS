<?php
//
//namespace App\DataTables;
//
//use App\Models\Employee;
//use App\Models\Installment;
//use App\Utils\GlobalConstant;
//use Illuminate\Database\Eloquent\Builder as QueryBuilder;
//use Illuminate\Support\Str;
//use Yajra\DataTables\EloquentDataTable;
//use Yajra\DataTables\Html\Builder as HtmlBuilder;
//use Yajra\DataTables\Html\Column;
//use Yajra\DataTables\Services\DataTable;
//
//class EmployeeDataTable extends DataTable
//{
//    /**
//     * Build the DataTable class.
//     *
//     * @param QueryBuilder $query Results from query() method.
//     */
//    public function dataTable(QueryBuilder $query): EloquentDataTable
//    {
//        return (new EloquentDataTable($query))
//            ->addColumn('action', function ($item) {
//                $buttons = '';
//                $buttons .= '<a class="dropdown-item" href="' . route('admin.employees.edit', $item->id) . '" title="Edit"><i class="mdi mdi-square-edit-outline"></i> Edit </a>';
//
////                $buttons .= '<a class="dropdown-item" href="' . route('admin.employees.show', $item->id) . '" title="Edit"><i class="fa fa-eye" aria-hidden="true"></i> View </a>';
//
//                // TO-DO: need to chnage the super admin ID to 1, while Super admin ID will 1
//                $buttons .= '<form action="' . route('admin.employees.destroy', $item->id) . '"  id="delete-form-' . $item->id . '" method="post" style="">
//                        <input type="hidden" name="_token" value="' . csrf_token() . '">
//                        <input type="hidden" name="_method" value="DELETE">
//                        <button class="dropdown-item text-danger" onclick="return makeDeleteRequest(event, ' . $item->id . ')"  type="submit" title="Delete"><i class="mdi mdi-trash-can-outline"></i> Delete</button></form>
//                        ';
//
//                return '<div class="btn-group dropleft">
//                <a href="#" onclick="return false;" class="btn btn-sm btn-dark text-white dropdown-toggle dropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
//                <div class="dropdown-menu">
//                ' . $buttons . '
//                </div>
//                </div>';
//            })
//            ->rawColumns(['action', 'avatar'])
//            ->setRowId('id');
//    }
//
//    /**
//     * Get the query source of dataTable.
//     */
//    public function query(Employee $model): QueryBuilder
//
//    {
//        return $model->newQuery()
//            ->orderBy('id', 'DESC')
//            ->select('employees.*');
//
//    }
//
//    /**
//     * Optional method if you want to use the html builder.
//     */
//    public function html(): HtmlBuilder
//    {
//        return $this->builder()
//            ->setTableId('user-table')
//            ->columns($this->getColumns())
//            ->minifiedAjax()
//            //->dom('Bfrtip')
//            ->orderBy(1)
//            ->selectStyleSingle()
//            ->addAction(['width' => '55px', 'class' => 'text-center', 'printable' => false, 'exportable' => false, 'title' => 'Action']);
//        //             ->buttons([
//        //                        Button::make('excel'),
//        //                        Button::make('csv'),
//        //                        Button::make('pdf'),
//        //                        Button::make('print'),
//        //                        Button::make('reset'),
//        //                        Button::make('reload')
//        //                    ]);
//
//    }
//
//    /**
//     * Get the dataTable columns definition.
//     */
//    public function getColumns(): array
//    {
//
//        return [
//            //            Column::computed('DT_RowIndex', 'SL#'),
//            // Column::make('avatar', 'avatar')->title('Avatar'),
//            Column::make('name', 'name')->title('Name'),
//            // Column::make('amount_paid', 'amount_paid')->title('Amount Collected'),
//
//        ];
//    }
//
//    /**
//     * Get the filename for export.
//     */
//    protected function filename(): string
//    {
//        return 'User_' . date('YmdHis');
//    }
//}


namespace App\DataTables;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmployeePaymentDataTable extends DataTable
{
    protected $month;

    public function __construct()
    {
        $this->month = request('month') ?? now()->format('Y-m');
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('commission_rate', function ($row) {
                return $row->commission_rate . '%';
            })
            ->addColumn('total_earned', function ($row) {
                return number_format($row->total_earned ?? 0, 2);
            })
            ->addColumn('total_paid', function ($row) {
                return number_format($row->total_paid ?? 0, 2);
            })
            ->addColumn('total_due', function ($row) {
                $due = ($row->total_earned ?? 0) - ($row->total_paid ?? 0);
                return '<strong>' . number_format($due, 2) . '</strong>';
            })
            ->addColumn('last_paid_date', function ($row) {
                return $row->last_paid_date ?? '-';
            })
            ->addColumn('status', function ($row) {
                $due = ($row->total_earned ?? 0) - ($row->total_paid ?? 0);

                if ($due <= 0) {
                    return '<span class="badge bg-success">Clear</span>';
                }

                if ($row->old_pending_count > 0) {
                    return '<span class="badge bg-danger">Outstanding</span>';
                }

                return '<span class="badge bg-warning text-dark">Pending</span>';
            })
            ->addColumn('action', function ($row) {
                $due = ($row->total_earned ?? 0) - ($row->total_paid ?? 0);
                $disabled = ($due <= 0) ? 'disabled' : '';
                $payBtn = '<button class="btn btn-sm btn-success pay-btn"
                                '.$disabled.'
                                data-id="'.$row->id.'"
                                data-earned="'.$row->total_earned.'"
                                data-paid="'.$row->total_paid.'">
                                💰 Pay
                           </button>';
                $viewBtn = '<a href="' . route('admin.employee-payment.show', $row->id) . '" class="btn btn-sm btn-dark">👁 Details</a>';

                return $payBtn . ' ' . $viewBtn;
            })
            ->setRowClass(function ($row) {
                $due = ($row->total_earned ?? 0) - ($row->total_paid ?? 0);

                if ($due <= 0) {
                    return '';
                }

                if ($row->old_pending_count > 0) {
                    return 'table-danger';
                }

                return 'table-warning';
            })
            ->rawColumns(['total_due', 'status', 'action']);
    }

    public function query(Employee $model): QueryBuilder
    {
        $month = $this->month;

        $commissionSub = DB::table('employee_commissions')
            ->select(
                'employee_id',
                DB::raw('SUM(commission_amount) as total_earned')
            )
            ->where('commission_month', $month)
            ->groupBy('employee_id');

        $paymentSub = DB::table('employee_payments')
            ->select(
                'employee_id',
                DB::raw('SUM(amount) as total_paid'),
                DB::raw('MAX(payment_date) as last_paid_date')
            )
            ->where('month', $month)
            ->groupBy('employee_id');

        return $model->newQuery()
            ->leftJoinSub($commissionSub, 'commissions', function ($join) {
                $join->on('employees.id', '=', 'commissions.employee_id');
            })
            ->leftJoinSub($paymentSub, 'payments', function ($join) {
                $join->on('employees.id', '=', 'payments.employee_id');
            })
            ->select(
                'employees.id',
                'employees.name',
                'employees.commission_rate',
                DB::raw('COALESCE(commissions.total_earned,0) as total_earned'),
                DB::raw('COALESCE(payments.total_paid,0) as total_paid'),
                DB::raw('payments.last_paid_date')
            )
            ->orderBy('employees.id', 'DESC');
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('employee-payment-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();
    }

    public function getColumns(): array
    {
        return [
            Column::make('name')->title('Employee'),
            Column::make('commission_rate')->title('Commission %'),
            Column::make('total_earned')->title('Total Earned'),
            Column::make('total_paid')->title('Total Paid'),
            Column::make('total_due')->title('Total Due'),
            Column::make('last_paid_date')->title('Last Paid'),
            Column::make('status')->title('Status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')
        ];
    }

    protected function filename(): string
    {
        return 'EmployeePayments_' . date('YmdHis');
    }
}
