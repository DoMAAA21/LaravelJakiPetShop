<?php

namespace App\DataTables;

use App\Models\Customer;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomerDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', 'customer.action');


            $btn = '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#CustomerModal"  data-id="'.$row->id.'"  > Edit</button>';
                return $btn;
        }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CustomerDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CustomerDataTable $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
         return $this->builder()
                    ->setTableId('customer-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(5)
                    ->buttons(
                        // Button::make('create'),
                        // Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    )->parameters([
                        'buttons' => ['excel','pdf','csv'],
                    ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
       
       return ([
                ['data' => 'id', 'name' => 'id', 'title' => 'Id'],
                ['data' => 'fname', 'name' => 'name', 'title' => 'First name'],
                 ['data' => 'lname', 'name' => 'name', 'title' => 'Surname'],
                ['data' => 'addressline', 'name' => 'addressline', 'title' => 'Address'],
                ['data' => 'town', 'name' => 'town', 'title' => 'Town'],
                
                ['data' => 'zipcode', 'name' => 'zipcode', 'title' => 'Zip'],
                ['data' => 'phone', 'name' => 'phone', 'title' => 'phone'],

                
                ['data' => 'action', 'name' => 'action', 'title' => 'Action'],
            ]);
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Customer_' . date('YmdHis');
    }
}
