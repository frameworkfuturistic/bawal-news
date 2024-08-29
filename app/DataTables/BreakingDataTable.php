<?php

namespace App\DataTables;

use App\Models\Breaking;
use App\Traits\LanguageTrait;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Exceptions\Exception;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Button;

class BreakingDataTable extends DataTable
{
    use LanguageTrait;

    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return EloquentDataTable
     * @throws Exception
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
      return datatables()
      ->eloquent($query)
      ->addColumn('action', function ($query) {
          $action = [
              'table' => 'user-table',
              'model' => $query,
          ];
          $action['del_url'] = route('breaking.destroy', $query->id);
         //  $action['edit_url'] = route('users.edit', $query->id);

          return view('layouts.partials._action', $action);
      });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Term $model
     * @return QueryBuilder
     */
    public function query(Breaking $model): QueryBuilder
    {
        if(is_null(request('filter')) || request('filter') == '0') {
            $reqLanguage = $this->getLanguageIdByAuth();
        } else {
            $reqLanguage = request('filter');
        }

        return $model->select('id', 'breaking_news')
            ->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return HtmlBuilder
     */
    public function html(): HtmlBuilder
    {
        $script = 'data.filter = $("#custom-filter").val();';
        return $this->builder()
            ->setTableId('breaking-table')
            ->columns($this->getColumns())
            ->minifiedAjax($url='', $script, [])
            ->dom("<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" .
                "<'row'<'col-sm-12'tr>>" .
                "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>")
            ->orderBy(1)
            ->orders([])
            ->parameters([
                'responsive' => true,
                'autoWidth' => false,

                'drawCallback' => 'function() {
                    "use strict";

                    $(".link-edit").on("click", function(e) {
                        e.preventDefault()

                        let editurl = $(this).attr("href");
                        let query = $(this).data("model");
                        let lang = $(this).data("lang");

                        $("#name").val(query.name);
                        $("#description").val(query.description);
                        if (query.translation) {
                            showTranslation(query.name);
                        } else {
                            hideTranslation(query.name);
                        }

                        $.each( JSON.parse(query.show_translations) , function( key, value ) {
                            console.log(value)
                          $("#translation-"+key).val(value);
                        });

                        $("form#insert").attr("href", editurl);

                        $("#btn-reset").removeAttr("hidden");
                        $("#btn-submit").attr("id","btn-submit-update");
                        $("button[type=submit]").html("'.__('button.update').'");

                        $("#name").removeClass("is-invalid");
                        $(".msg-error-name").html("");
                        $("#description").removeClass("is-invalid");
                        $(".msg-error-description").html("");
                    });

                    $(".delete").on("click", function() {
                        let table = $(this).data("table");
                        let url = $(this).data("url");
                        sweetalert2(table, url);
                    })

                     if(document.getElementById("translation")){
                        document.getElementById("translation").removeAttribute("disabled");
                    }
                }'
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('id')->title(__('table.id'))
                ->orderable(false),
            Column::make('breaking_news')->title(__('table.breaking_news'))
                ->orderable(false),
            Column::computed('action')->title(__('table.action'))
                ->addClass('text-center')
                ->width(60),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Tags_' . date('YmdHis');
    }
}
