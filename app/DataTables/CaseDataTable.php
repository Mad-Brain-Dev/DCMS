<?php

namespace App\DataTables;

use App\Models\Cases;
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
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($item) {
                $buttons = '';


                if (auth()->user()->can('Edit Case')) {
                    $buttons .= '<a class="dropdown-item" href="' . route('admin.cases.edit', $item->id) . '" title="Edit"><i class="mdi mdi-square-edit-outline"></i> Edit </a>';
                }

                if (auth()->user()->can('Case View')) {
                    $buttons .= '<a class="dropdown-item" href="' . route('admin.cases.show', $item->id) . '" title="Show"><i class="fa fa-eye" aria-hidden="true"></i> Show </a>';
                }
                // if (auth()->user()->can('Print Warrant')) {
                //     $buttons .= '<a class="dropdown-item" href="' . route('printable.case.agreement', $item->id) . '" title="Show"><i class="fas fa-print"></i> Print Warrant </a>';
                // }
                // if (auth()->user()->can('Print Letter')) {
                //     $buttons .= '<a class="dropdown-item" href="' . route('printable.case.letter', $item->id) . '" title="Show"><i class="fas fa-paste"></i> Print Letter </a>';
                // }



                $buttons .= '<a class="dropdown-item" href="' . route('cases.debtor.details', $item->id) . '" title="Show"><i class="fas fa-paste"></i> Debtor Details </a>';

                // TO-DO: need to chnage the super admin ID to 1, while Super admin ID will 1

                if (auth()->user()->can('Delete Case')) {
                    $buttons .= '<form action="' . route('admin.cases.destroy', $item->id) . '"  id="delete-form-' . $item->id . '" method="post" style="">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <input type="hidden" name="_method" value="DELETE">
                    <button class="dropdown-item text-danger" onclick="return makeDeleteRequest(event, ' . $item->id . ')"  type="submit" title="Delete"><i class="mdi mdi-trash-can-outline"></i> Delete</button></form>
                    ';
                }

                return '<div class="btn-group dropleft">
                <a href="#" onclick="return false;" class="btn btn-sm btn-dark text-white dropdown-toggle dropdown" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></a>
                <div class="dropdown-menu">
                ' . $buttons . '
                </div>
                </div>';
                // })->editColumn('avatar', function ($item) {
                //     return '<img class="ic-img-32" src="' . $item->avatar_url . '" alt="' . $item->last_name . '" />';
            })->editColumn('client_id', function ($item) {
                $name = $item->client->name;
                return $name;
            })
            ->editColumn('total_amount_owed', function ($item) {

                //                return $item->total_amount_owed;
                return number_format($item->total_amount_owed, 2);
            })
            ->editColumn('total_amount_balance', function ($item) {

                return totalBalance($item->id);
            })
            //->editColumn('status',function ($item){
            //     $badge = $item->status == GlobalConstant::STATUS_ACTIVE ? "bg-success" : "bg-danger";
            //     return '<span class="badge ' . $badge . '">' . Str::upper($item->status) . '</span>';
            // })->editColumn('debtor_id',function ($item){
            //     return '<span class="text-capitalize">' . $item->user_type. '</span>';
            // })->filterColumn('first_name', function ($query, $keyword) {
            //     $sql = "CONCAT(users.first_name,'-',users.last_name)  like ?";
            //     $query->whereRaw($sql, ["%{$keyword}%"]);
            // })
            ->rawColumns(['action', 'avatar', 'status', 'debtor_id', 'total_amount_owed', 'total_amount_balance'])
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
