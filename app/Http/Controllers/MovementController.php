<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movement;
use App\Account;
use App\Document;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Input;
class MovementController extends Controller
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

    public function listAllMovements($account){
        $movements = Movement::join('accounts', 'accounts.id','=', 'movements.account_id')
                    ->join('movement_categories', 'movements.movement_category_id', '=', 'movement_categories.id')
                    ->leftJoin('documents', 'movements.document_id', '=', 'documents.id')
                    ->where('accounts.id', '=', $account)
                    ->select('movements.*', 'documents.original_name', 'movement_categories.name')
                    ->orderBy('date', 'desc')
                    ->orderBy('id', 'desc')
                    ->get();
    	
    	return view('movements.listAllMovements', compact('movements', 'account'));
    }

    public function create($account)
    {
        Account::findOrFail($account);
        $movement = new Movement;
        return view('movements.createMovement', compact('movement', 'account'));
    }

    public function store(Request $request, $account)
    {
        if ($request->has('cancel')) {
            return redirect()->action('DashboardController@index', Auth::user());
        }

        $movement = $request->validate([
            'type' => 'required',
            'movement_category_id' => 'required|min:1|max:14',
            'date' => 'required|date',
            'value' => 'required|integer',
            'description' => 'nullable|string',
            ]);

        $movement['account_id'] = $account;
        
        $numMovements = Movement::where('account_id', '=', $account)
                                ->select('movements.*')
                                ->get();

        $contaAtual = Account::findOrFail($account);

        if (count($numMovements) == 0) {
            $movement['start_balance'] = $contaAtual->start_balance;
            
            if ($request->type=='expense') {
                $movement['end_balance'] = $contaAtual->start_balance - $request->value; 
            }else{
                $movement['end_balance'] = $contaAtual->start_balance + $request->value; 
            }
        }else{
            $lastMovement = Movement::join('accounts', 'accounts.id','=', 'movements.account_id')
                    ->where('accounts.id', '=', $account)
                    ->where('movements.date', '<=', $request->date)
                    ->select('movements.*')
                    ->orderBy('movements.date', 'desc')
                    ->orderBy('movements.id', 'desc')
                    ->first();
            //$lastMovement = Movement::findOrFail($lastMovementId);

            
            $movement['start_balance'] = $lastMovement->end_balance;
            
            if ($request->type=='expense') {
                $movement['end_balance'] = $lastMovement->end_balance - $request->value; 
            }else{
                $movement['end_balance'] = $lastMovement->end_balance + $request->value; 
            }

            $movementsUp = Movement::join('accounts', 'accounts.id','=', 'movements.account_id')
                    ->where('accounts.id', '=', $account)
                    ->where('movements.date', '>', $request->date)
                    ->select('movements.*')
                    ->orderBy('movements.date', 'asc')
                    ->orderBy('movements.id', 'asc')
                    ->get();


        
            if (count($movementsUp)>0) {
                for ($i=0; $i < count($movementsUp); $i++) {
                    if ($i==0) {
                        if ($request->type=='expense') {
                            Movement::where('id', '=', $movementsUp[$i]->id)
                                ->update(['end_balance' => ($lastMovement->end_balance - $request->value) - $movementsUp[$i]->value,
                                          'start_balance' => $lastMovement->end_balance - $request->value]);
                        }else{
                            Movement::where('id', '=', $movementsUp[$i]->id)
                                ->update(['end_balance' => ($lastMovement->end_balance + $request->value) + $movementsUp[$i]->value,
                                          'start_balance' => $lastMovement->end_balance + $request->value]);
                        }
                    }else{
                        $end_balance_movement = Account::join('movements', 'movements.account_id', '=', 'accounts.id')
                                ->where('accounts.id', '=', $account)
                                ->where('movements.id', '=', $movementsUp[($i-1)]->id)
                                ->select('movements.end_balance')
                                ->first();

                     
                        if ($movementsUp[$i]->type == 'expense') {
                            DB::table('accounts')
                                ->join('movements', 'movements.account_id', '=', 'accounts.id')
                                ->where('accounts.id', '=', $account)
                                ->where('movements.id', '=', $movementsUp[$i]->id)
                                ->update(['movements.start_balance' => $end_balance_movement->end_balance,
                                        'movements.end_balance' => ($end_balance_movement->end_balance - $movementsUp[$i]->value) ]);
                            

                        }else{
                            DB::table('accounts')
                                ->join('movements', 'movements.account_id', '=', 'accounts.id')
                                ->where('accounts.id', '=', $account)
                                ->where('movements.id', '=', $movementsUp[$i]->id)
                                ->update(['movements.start_balance' => $end_balance_movement->end_balance,
                                        'movements.end_balance' => ($end_balance_movement->end_balance + $movementsUp[$i]->value)]);
                        }
                    }   
                }
            }
        }

        if (count($numMovements) == 0) {
            if ($request->type=='expense') {
                $contaCurrBalance = $contaAtual->start_balance - $request->value; 
            }else{
                $contaCurrBalance = $contaAtual->start_balance + $request->value; 
            }

            Account::where('id', '=', $account)
                ->update(['current_balance' => $contaCurrBalance]);
        }
            
        

        

        /*DB::table('accounts')
                ->where('accounts.id', '=', $movementModel->account_id)
                ->update(['accounts.current_balance' => $lastMovement->end_balance]);*/

        
        
        
        
        
        Movement::create($movement);

        $numMov = Movement::where('account_id', '=', $account)
                                ->select('movements.*')
                                ->get();


        if (count($numMov) > 0) {
            $lastMovement = Movement::join('accounts', 'accounts.id','=', 'movements.account_id')
                    ->where('accounts.id', '=', $account)
                    ->select('movements.*')
                    ->orderBy('date', 'desc')
                    ->orderBy('id', 'desc')
                    ->first();
            

            Account::where('id', '=', $account)
                ->update(['current_balance' => $lastMovement->end_balance]);
        }
        
        return redirect()->action('DashboardController@index', Auth::user());
    }

    public function edit (Movement $movement){
               
        return view('movements.editMovement', compact('movement'));
    }

    public function update(Request $request, $id)
    {
        if ($request->has('cancel')) {
            return redirect()->action('DashboardController@index', Auth::user());
        }
        
        $movement = $request->validate([
            'type' => 'required',
            'date' => 'required',
            'value' => 'required',
            ]);

        $movementModel = Movement::findOrFail($id);
        
        $numMovements = Movement::where('account_id', '=', $movementModel->account_id)
                                ->select('movements.*')
                                ->get();

        $contaAtual = Account::findOrFail($movementModel->account_id);
        
        if (count($numMovements) == 0) {
            if ($request->type=='expense') {
                Movement::where('id', '=', $id)
                    ->update(['start_balance' => $contaAtual->start_balance,
                              'end_balance' => $contaAtual->start_balance - $request->value]);
            }else{
                Movement::where('id', '=', $id)
                    ->update(['start_balance' => $contaAtual->start_balance,
                              'end_balance' => $contaAtual->start_balance + $request->value]);
            }

        }  
        
        $movements = Movement::join('accounts', 'accounts.id','=', 'movements.account_id')
                    ->where('accounts.id', '=', $movementModel->account_id)
                    ->where('movements.date', '>=', $request->date)
                    ->select('movements.*')
                    ->orderBy('movements.date', 'asc')
                    ->orderBy('movements.id', 'asc')
                    ->get();

        
        if (count($movements)>0) {
            for ($i=0; $i < count($movements); $i++) {
                if ($i==0) {
                    if ($request->type=='expense') {
                        Movement::where('id', '=', $id)
                            ->update(['end_balance' => $movementModel->start_balance - $request->value]);
                    }else{
                        Movement::where('id', '=', $id)
                            ->update(['end_balance' => $movementModel->start_balance + $request->value]);
                    }
                }else{
                    $end_balance_movement = Account::join('movements', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.id', '=', $movementModel->account_id)
                            ->where('movements.id', '=', $movements[($i-1)]->id)
                            ->select('movements.end_balance')
                            ->first();

                 
                    if ($movements[$i]->type == 'expense') {
                        DB::table('accounts')
                            ->join('movements', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.id', '=', $movementModel->account_id)
                            ->where('movements.id', '=', $movements[$i]->id)
                            ->update(['movements.start_balance' => $end_balance_movement->end_balance,
                                    'movements.end_balance' => ($end_balance_movement->end_balance - $movements[$i]->value) ]);
                        

                    }else{
                        DB::table('accounts')
                            ->join('movements', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.id', '=', $movementModel->account_id)
                            ->where('movements.id', '=', $movements[$i]->id)
                            ->update(['movements.start_balance' => $end_balance_movement->end_balance,
                                    'movements.end_balance' => ($end_balance_movement->end_balance + $movements[$i]->value)]);
                    }
                }   
            }
        }

                
        /*$lastMovementId = Movement::join('accounts', 'accounts.id','=', 'movements.account_id')
        ->where('accounts.id', '=', $movementModel->account_id)
        ->max('movements.id');

        $lastMovement = Movement::findOrFail($lastMovementId);*/

        $lastMovement = Movement::join('accounts', 'accounts.id','=', 'movements.account_id')
                    ->where('accounts.id', '=', $movementModel->account_id)
                    ->select('movements.*')
                    ->orderBy('date', 'desc')
                    ->orderBy('id', 'desc')
                    ->first();

        DB::table('accounts')
                ->where('accounts.id', '=', $movementModel->account_id)
                ->update(['accounts.current_balance' => $lastMovement->end_balance]);
        

    

        
        $movementModel->fill($movement);
        $movementModel->save();
            
        return redirect()->action('DashboardController@index', Auth::user());
    }

    public function delete($id)
    {
        $movement = Movement::find($id);

        $account = Account::findOrFail($movement->account_id);

        $numMovements = Movement::where('account_id', '=', $movement->account_id)
                                ->select('movements.*')
                                ->get();

        if (count($numMovements)==1) {
           DB::table('accounts')
                ->where('accounts.id', '=', $movement->account_id)
                ->update(['accounts.current_balance' => $account->start_balance]);
        }


        $movements = Movement::join('accounts', 'accounts.id','=', 'movements.account_id')
                    ->where('accounts.id', '=', $movement->account_id)
                    ->where('movements.date', '>=', $movement->date)
                    ->select('movements.*')
                    ->orderBy('movements.date', 'asc')
                    ->orderBy('movements.id', 'asc')
                    ->get();

        if (count($movements) > 1) {
            for ($i=1; $i < count($movements); $i++) {
                if ($i==1) {
                    if ($movements[$i]->type == 'expense') {
                        DB::table('accounts')
                            ->join('movements', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.id', '=', $movement->account_id)
                            ->where('movements.id', '=', $movements[$i]->id)
                            ->update(['movements.start_balance' => $movement->start_balance,
                                    'movements.end_balance' => ($movement->start_balance - $movements[$i]->value) ]);
                        

                    }else{
                        DB::table('accounts')
                            ->join('movements', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.id', '=', $movement->account_id)
                            ->where('movements.id', '=', $movements[$i]->id)
                            ->update(['movements.start_balance' => $movement->start_balance,
                                    'movements.end_balance' => ($movement->start_balance + $movements[$i]->value)]);
                    }
                }else{
                $end_balance_movement = Account::join('movements', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.id', '=', $movement->account_id)
                            ->where('movements.id', '=', $movements[($i-1)]->id)
                            ->select('movements.end_balance')
                            ->first();

                if ($movements[$i]->type == 'expense') {
                        DB::table('accounts')
                            ->join('movements', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.id', '=', $movement->account_id)
                            ->where('movements.id', '=', $movements[$i]->id)
                            ->update(['movements.start_balance' => $end_balance_movement->end_balance,
                                    'movements.end_balance' => ($end_balance_movement->end_balance - $movements[$i]->value) ]);
                        

                    }else{
                        DB::table('accounts')
                            ->join('movements', 'movements.account_id', '=', 'accounts.id')
                            ->where('accounts.id', '=', $movement->account_id)
                            ->where('movements.id', '=', $movements[$i]->id)
                            ->update(['movements.start_balance' => $end_balance_movement->end_balance,
                                    'movements.end_balance' => ($end_balance_movement->end_balance + $movements[$i]->value)]);
                    }
                }
            }
        }

        $movement->delete();

        if (count($numMovements)>1) {

            $lastMovement = Movement::join('accounts', 'accounts.id','=', 'movements.account_id')
                    ->where('accounts.id', '=', $movement->account_id)
                    ->select('movements.*')
                    ->orderBy('date', 'desc')
                    ->orderBy('id', 'desc')
                    ->first();

            DB::table('accounts')
                    ->where('accounts.id', '=', $movement->account_id)
                    ->update(['accounts.current_balance' => $lastMovement->end_balance]);
        }
        
        return redirect()->action('DashboardController@index', Auth::user());
    }

    public function download($id)
    {

        $movement = DB::table('documents')
                    ->join('movements', 'movements.document_id',  '=', 'documents.id')
                    ->where('documents.id', '=', $id)
                    ->select('movements.id', 'movements.account_id', 'documents.type')
                    ->first();


        return Storage::disk('local')->download('documents/' . $movement->account_id . '/' . $movement->id . '.' . $movement->type);

    }

    public function view($id)
    {
        $movement = DB::table('documents')
                    ->join('movements', 'movements.document_id',  '=', 'documents.id')
                    ->where('documents.id', '=', $id)
                    ->select('movements.id', 'movements.account_id', 'documents.type')
                    ->first();


        //dd(Storage::url('documents/' . $movement->account_id . '/' . $movement->id . '.png'));
        return response()->file(storage_path('app/documents/' . $movement->account_id . '/' . $movement->id . '.' . $movement->type));

    }

    public function deleteDocument($id)
    {
        $document = Document::findOrFail($id);

        Movement::where('movements.document_id', '=', $id)
                    ->update(['movements.document_id' =>  NULL]);
        
        $document->delete();

        return redirect()->action('DashboardController@index', Auth::user());

    }

    public function createDocument($movement){
        $document = new Document;
        
        return view('documents.createDocument', compact('document', 'movement'));
    }


    public function storeDocument(Request $request, $id){
        if ($request->has('cancel')) {
            return redirect()->action('DashboardController@index', Auth::user());
        }

        $movement = Movement::findOrFail($id);

        $document = $request->validate([
            'original_name' => 'mimes:jpeg,jpg,png|required|max:1999|file',
            'description' => 'nullable',
        ]);

        $file = $request->file('original_name');


        if ($file != null) {
            $document = Document::create([
                'original_name' => $file->getClientOriginalName(),
                'description' => $request->input('description'),
                'type' => $file->getClientOriginalExtension(),
            ]);
        }

        if ($file != null) {
            if ($file->isValid()) {
                $name = $movement->id . '.' . $file->getClientOriginalExtension();
                Storage::disk('local')->putFileAs('documents/' . $movement->account_id, $file, $name);
            }
        }



        Movement::where('movements.id', '=', $id)
                    ->update([
                        'movements.document_id' => $document->id
                    ]);
        
        return redirect()->action('DashboardController@index', Auth::user());

    }
}
