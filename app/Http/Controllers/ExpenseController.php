<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Type;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::latest()->get();
        return view('expenses.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Expense::class);
        
        $types = Type::all();
        return view('expenses.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Expense::class);
        
        $request->validate([
            'amount' => 'required',
            'type' => 'required'
        ]);

        $expense = new Expense();
        $expense->type_id = $request->type;
        $expense->amount = $request->amount;
        $expense->save();
        return redirect()->route('expenses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        $this->authorize('update', $expense);
        
        $types = Type::all();
        return view('expenses.create', compact('types', 'expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        $this->authorize('update', $expense);
        
        $request->validate([
            'amount' => 'required',
            'type' => 'required'
        ]);

        $expense->type = $request->type;
        $expense->category = $request->category;
        $expense->update();
        return redirect()->route('expenses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        
        $expense->delete();
        return redirect()->back();
    }
}
