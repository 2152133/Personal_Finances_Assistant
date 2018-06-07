<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Khill\Lavacharts\Lavacharts;
use Carbon\Carbon;

class StatisticsController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $me = Auth::user();



        if($request->has('fromDate') && $request->has('toDate')){

            $from = $request->input('fromDate');
            $to = $request->input('toDate');

            //dd($from->toDateString());
            $totalReceitas = abs(DB::table('movements')
                            ->join('accounts', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.owner_id', '=', $me->id)
                            ->where('type', '=', 'revenue')
                            ->select('movements.*', 'accounts.owner_id')
                            ->whereBetween('movements.date', [$from, $to])
                            ->sum('value'));

            $totalDespesas = abs(DB::table('movements')
                            ->join('accounts', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.owner_id', '=', $me->id)
                            ->where('type', '=', 'expense')
                            ->select('movements.*', 'accounts.owner_id')
                            ->whereBetween('movements.date', [$from, $to])
                            ->sum('value'));
        } else {
            $totalReceitas = abs(DB::table('movements')
                            ->join('accounts', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.owner_id', '=', $me->id)
                            ->where('type', '=', 'revenue')
                            ->select('movements.*', 'accounts.owner_id')
                            ->sum('value'));

            $totalDespesas = abs(DB::table('movements')
                            ->join('accounts', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.owner_id', '=', $me->id)
                            ->where('type', '=', 'expense')
                            ->select('movements.*', 'accounts.owner_id')
                            ->sum('value'));
        }
        
        
        
        //Criar o grafico
        $dataTable = \Lava::DataTable();
        $dataTable->addStringColumn('nome')
                    ->addNumberColumn('total');


        $dataTable->addRow(['totalReceitas', $totalReceitas])
                    ->addRow(['totalDespesas',$totalDespesas]);   

        \Lava::PieChart('Totais', $dataTable, [
                                    'title'  => 'Totais de despesas e receitas',
                                    'is3D'   => true
                                    ]);

        return view('pages.statistics', compact('totalReceitas', 'totalDespesas'));
    }
}
