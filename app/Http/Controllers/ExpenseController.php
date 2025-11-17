<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ExpenseController extends Controller
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
        
        $expenses = Expense::with('approver')
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
        
        return view('expenses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create expenses');
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:equipment,medicines,utilities,maintenance,staff,supplies,other',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,bank_transfer,check',
            'expense_date' => 'required|date',
            'due_date' => 'nullable|date|after:expense_date',
            'vendor' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $expenseData = $request->all();
        $expenseData['expense_number'] = 'EXP-' . strtoupper(Str::random(8));
        $expenseData['status'] = 'pending';

        Expense::create($expenseData);

        return redirect()->route('expenses.index')
            ->with('success', __('expense_created_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {
        Gate::authorize('view expenses');
        
        $expense->load('approver');
        
        return view('expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        Gate::authorize('edit expenses');
        
        return view('expenses.edit', compact('expense'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expense $expense)
    {
        Gate::authorize('edit expenses');
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:equipment,medicines,utilities,maintenance,staff,supplies,other',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,bank_transfer,check',
            'expense_date' => 'required|date',
            'due_date' => 'nullable|date|after:expense_date',
            'vendor' => 'nullable|string|max:255',
            'reference_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $expense->update($request->all());

        return redirect()->route('expenses.index')
            ->with('success', __('expense_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        Gate::authorize('delete expenses');
        
        $expense->delete();

        return redirect()->route('expenses.index')
            ->with('success', __('expense_deleted_successfully'));
    }

    /**
     * Approve an expense.
     */
    public function approve(Request $request, Expense $expense)
    {
        Gate::authorize('approve expenses');
        
        $expense->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('expenses.index')
            ->with('success', __('expense_approved_successfully'));
    }

    /**
     * Reject an expense.
     */
    public function reject(Request $request, Expense $expense)
    {
        Gate::authorize('approve expenses');
        
        $expense->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);

        return redirect()->route('expenses.index')
            ->with('success', __('expense_rejected_successfully'));
    }

    /**
     * Mark expense as paid.
     */
    public function markPaid(Request $request, Expense $expense)
    {
        Gate::authorize('edit expenses');
        
        $expense->update([
            'status' => 'paid',
        ]);

        return redirect()->route('expenses.index')
            ->with('success', __('expense_marked_paid_successfully'));
    }
}