<?php

namespace App\DataTables;

use App\Models\Invoice;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class InvoiceDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('client', function ($row) {
                return $row->client->name ?? '-';
            })
            ->editColumn('issued_date', function ($row) {
                return optional($row->issued_date)->format('d M Y');
            })
            ->editColumn('final_invoice_amount', function ($row) {
                return '$ ' . number_format($row->final_invoice_amount, 2);
            })
            ->addColumn('total_collected', function ($row) {
                return '$ ' . number_format(
                        $row->total_collected_client + $row->total_collected_securre,
                        2
                    );
            })
            ->addColumn('payable_to', function ($row) {
                return ucfirst($row->final_payable_to);
            })
            ->addColumn('status_badge', function ($row) {

                $class = match ($row->status) {
                    'issued' => 'primary',
                    'paid' => 'success',
                    'cancelled' => 'danger',
                };

                return '<span class="badge bg-' . $class . '">' .
                    ucfirst($row->status) .
                    '</span>';
            })
            ->addColumn('action', function ($item) {

                $buttons = '';

                $buttons .= '<a class="dropdown-item" href="' .
                    route('admin.invoices.show', $item->id) .
                    '"><i class="mdi mdi-eye-outline"></i> View</a>';

                $buttons .= '<a href="#"
                        class="dropdown-item change-status-btn"
                        data-id="' . $item->id . '"
                        data-status="' . $item->status . '"
                        data-issued="'.optional($item->issued_date)->format('Y-m-d').'"
                        data-paid="'.optional($item->paid_date)->format('Y-m-d').'">
                        <i class="mdi mdi-refresh"></i> Change Status
                        </a>';

                if ($item->status != 'paid' || $item->status != 'cancelled'){
                    $buttons .= '<form action="' .
                        route('admin.invoices.destroy', $item->id) .
                        '" method="post">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <button class="dropdown-item text-danger"
                    onclick="return confirm(\'Are you sure?\')">
                    <i class="mdi mdi-trash-can-outline"></i> Cancel
                    </button>
                    </form>';
                }

                return '<div class="btn-group dropleft">
                    <a href="#" class="btn btn-sm btn-dark text-white dropdown-toggle"
                       data-bs-toggle="dropdown">
                       <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <div class="dropdown-menu">
                        '.$buttons.'
                    </div>
                </div>';
            })
            ->rawColumns(['status_badge', 'action'])
            ->setRowId('id');
    }

    public function query(Invoice $model): QueryBuilder
    {
        $query = $model->newQuery()->with('client');

        if (request('from') && request('to')) {
            $query->whereBetween('issued_date', [request('from'), request('to')]);
        }

        if (request('client_id')) {
            $query->where('client_id', request('client_id'));
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        if (request('month')) {
            $date = \Carbon\Carbon::parse(request('month'));

            $query->whereYear('issued_date', $date->year)
                ->whereMonth('issued_date', $date->month);
        }

        return $query->orderByDesc('id');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('invoice-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle();
    }

    public function getColumns(): array
    {
        return [
            Column::make('invoice_number')->title('Invoice #'),
            Column::make('client')->title('Client'),
            Column::make('issued_date')->title('Date'),
            Column::make('total_collected')->title('Total Collected'),
            Column::make('final_invoice_amount')->title('Final Amount'),
            Column::make('payable_to')->title('Payable To'),
            Column::make('status_badge')->title('Status'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center')
        ];
    }
}
