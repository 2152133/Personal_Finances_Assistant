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


            /* Totais gerais de receitas e despesas entre duas datas*/
                $revenueCategoriesInfo = DB::table('movements')
                                ->join('accounts', 'movements.account_id', '=', 'accounts.id')
                                ->join('movement_categories', 'movements.movement_category_id', '=', 'movement_categories.id')
                                ->where('accounts.owner_id', '=', $me->id)
                                ->where('movements.type', '=', 'revenue')
                                ->whereBetween('movements.date', [$from, $to])
                                ->selectRaw('SUM(movements.value) as total, movement_categories.name')
                                ->groupBy('movement_categories.name')->get();

                
                $expenseCategoriesInfo = DB::table('movements')
                                ->join('accounts', 'movements.account_id', '=', 'accounts.id')
                                ->join('movement_categories', 'movements.movement_category_id', '=', 'movement_categories.id')
                                ->where('accounts.owner_id', '=', $me->id)
                                ->where('movements.type', '=', 'expense')
                                ->whereBetween('movements.date', [$from, $to])
                                ->selectRaw('SUM(movements.value) as total, movement_categories.name')
                                ->groupBy('movement_categories.name')->get();
        } else {
            /* Totais gerais de receitas e despesas*/
                $revenueCategoriesInfo = DB::table('movements')
                                ->join('accounts', 'movements.account_id', '=', 'accounts.id')
                                ->join('movement_categories', 'movements.movement_category_id', '=', 'movement_categories.id')
                                ->where('accounts.owner_id', '=', $me->id)
                                ->where('movements.type', '=', 'revenue')
                                ->selectRaw('SUM(movements.value) as total, movement_categories.name')
                                ->groupBy('movement_categories.name')->get();
            

                $expenseCategoriesInfo = DB::table('movements')
                                ->join('accounts', 'movements.account_id', '=', 'accounts.id')
                                ->join('movement_categories', 'movements.movement_category_id', '=', 'movement_categories.id')
                                ->where('accounts.owner_id', '=', $me->id)
                                ->where('movements.type', '=', 'expense')
                                ->selectRaw('SUM(movements.value) as total, movement_categories.name')
                                ->groupBy('movement_categories.name')->get();
        }
        
        
        
        /* Criar o grafico dos totais globais */
            $tabelaTotaisGlobais = \Lava::DataTable();
            $tabelaTotaisGlobais->addStringColumn('nome')
                                ->addNumberColumn('total');

            $globalTotalRevenue = 0;
            $globalTotalExpense = 0;
            foreach ($revenueCategoriesInfo as $revenueCategoryInfo) {
                $globalTotalRevenue += $revenueCategoryInfo->total;
            }

            foreach ($expenseCategoriesInfo as $expenseCategoryInfo) {
                $globalTotalExpense += abs($expenseCategoryInfo->total);
            }

            $tabelaTotaisGlobais->addRow(['Total de receitas', $globalTotalRevenue])
                                ->addRow(['Total de despesas',$globalTotalExpense]);   

            \Lava::PieChart('TotaisGlobais', $tabelaTotaisGlobais, [
                                        'title'  => '',
                                        'is3D'   => false
                                        ]);

        
        /* Cria os graficos para as receitas de cada categoria */
            $tabelaTotaisReceitas = \Lava::DataTable();
            $tabelaTotaisReceitas->addStringColumn('nome')
                                    ->addNumberColumn('total');

            foreach ($revenueCategoriesInfo as $revenueCategoryInfo) {
                $tabelaTotaisReceitas->addRow([$revenueCategoryInfo->name, $revenueCategoryInfo->total]);
            }
            
            \Lava::BarChart('TotaisReceitas', $tabelaTotaisReceitas);


        /* Cria os graficos para as receitas de cada categoria */
            $tabelaTotaisDespesas = \Lava::DataTable();
            $tabelaTotaisDespesas->addStringColumn('nome')
                                    ->addNumberColumn('total');

            foreach ($expenseCategoriesInfo as $expenseCategoryInfo) {
                $tabelaTotaisDespesas->addRow([$expenseCategoryInfo->name, abs($expenseCategoryInfo->total)]);
            }
            
            \Lava::BarChart('TotaisDespesas', $tabelaTotaisDespesas);

        return view('pages.statistics');
    }
}
