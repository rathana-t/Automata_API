<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FiniteAutomaton;
use Illuminate\Support\Facades\DB;

class FiniteAutomatonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('finite_automatons')->whereNull('deleted_at')->get();
        $data = $data->map(function ($item, $key) {
            return  [
                'id' => $item->id,
                'number_of_state' => $item->number_of_state,
                'start_state' => $item->start_state,
                'number_of_symbol' => $item->number_of_symbol,
                'final_state' => unserialize($item->final_state),
                'symbol' => unserialize($item->symbol),
                'transaction' => unserialize($item->transaction),
                'transaction_epsilon' => unserialize($item->transaction_epsilon),
            ];
        });

        return response()->json($data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $automata = new FiniteAutomaton();
        $automata->number_of_state = $request->number_of_state;
        $automata->start_state = $request->start_state;
        $automata->final_state = serialize($request->final_state);
        $automata->number_of_symbol = $request->number_of_symbol;
        $automata->symbol = serialize($request->symbol);
        $automata->transaction = serialize($request->transaction);
        $automata->transaction_epsilon = serialize($request->transaction_epsilon);

        $automata->save();

        return response()->json($automata);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FiniteAutomaton  $finiteAutomaton
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $automata = FiniteAutomaton::findOrFail($id);
        $automata->number_of_state = $request->number_of_state;
        $automata->start_state = $request->start_state;
        $automata->final_state = serialize($request->final_state);
        $automata->number_of_symbol = $request->number_of_symbol;
        $automata->symbol = serialize($request->symbol);
        $automata->transaction = serialize($request->transaction);
        $automata->transaction_epsilon = serialize($request->transaction_epsilon);

        $automata->save();

        return response()->json($automata);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FiniteAutomaton  $finiteAutomaton
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $data = FiniteAutomaton::where('id', $id)->whereNull('deleted_at')->first();
        unserialize($data->final_state);
        unserialize($data->symbol);
        unserialize($data->transaction);
        unserialize($data->transaction_epsilon);
        $data->delete();
        return response()->json($data);
    }
}