<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Repo\TableRepository as Table;

class TableController extends Controller
{
    public $table;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct( Table $table )
    {
        $this->middleware('auth');
        $this->table = $table;
    }

    public function index() {
        $tables = $this->table->find_all();
        $tables_normalized = $this->table->find_normalized();
        $tables_not_normalized = $this->table->find_not_normalized();
        return view( 'tables.index', ['tables'=>$tables, 'tables_normalized'=>$tables_normalized, 'tables_not_normalized'=>$tables_not_normalized] );
    }

    public function integration() {
        $this->table->integration();
        return redirect( 'tables' );
    }

    public function detail( $table ) {
        $table = $this->table->find_by_name( $table );
        return view('tables.detail', [
            'table' => $table
        ]);
    }

    public function normalization_all( Request $r ) {
        $tables = $r->input('table');
        $this->table->update_tables( $tables );
        return redirect( 'tables' );
    }

    public function normalization_table( $table, Request $r ) {
        $fields = $r->input( 'fields' );
        if ( $this->table->normalize_table( $table, $fields ) == true ) {
            return redirect( 'table/' . $table . '/file-generate');
        } else {
            return redirect( 'tables' );
        }
    }

    public function remove_normalization( $table ) {
        $this->table->remove_normalization( $table );
        return redirect('tables');
    }

    public function file_generate( $table ) {
        $this->table->model_generate( $table );
        $this->table->repository_generate( $table );
        return redirect('table/' . $table);
    }

    public function get_belongs( $table ) {
        $this->table->get_belongs_to( $table );
    }

    public function get_hasmany( $table ) {
        $this->table->get_has_many( $table );
    }
}
