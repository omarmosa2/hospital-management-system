<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Support\Str;

class BillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('view expenses');
        
        $expenses = \App\Models\Expense::with('approver')
            ->orderBy('expense_date', 'desc')
            ->paginate(15);
            
        return view('bills.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create expenses');
        
        return redirect()->route('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return redirect()->route('expenses.create');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bill $bill)
    {
        return redirect()->route('expenses.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bill $bill)
    {
        return redirect()->route('expenses.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bill $bill)
    {
        return redirect()->route('expenses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bill $bill)
    {
        return redirect()->route('expenses.index');
    }

    /**
     * Process payment for a bill
     */
    public function processPayment(Request $request, Bill $bill)
    {
        return redirect()->route('expenses.index');
    }
}
