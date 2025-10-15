<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of all accounts.
     */
    public function index()
    {
        Gate::authorize('manage accounts');
        
        $users = User::with('roles')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('accounts.index', compact('users'));
    }

    /**
     * Show the form for creating a new account.
     */
    public function create()
    {
        Gate::authorize('manage accounts');
        
        $roles = \Spatie\Permission\Models\Role::all();
        return view('accounts.create', compact('roles'));
    }

    /**
     * Store a newly created account.
     */
    public function store(Request $request)
    {
        Gate::authorize('manage accounts');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => true,
        ]);

        // Assign roles
        $roleIds = $request->roles;
        $roles = \Spatie\Permission\Models\Role::whereIn('id', $roleIds)->get();
        $user->syncRoles($roles);

        return redirect()->route('accounts.index')
            ->with('success', 'تم إنشاء الحساب بنجاح');
    }

    /**
     * Show the form for editing the specified account.
     */
    public function edit(User $user)
    {
        Gate::authorize('manage accounts');
        
        $roles = \Spatie\Permission\Models\Role::all();
        return view('accounts.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified account.
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('manage accounts');
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Update roles
        $roleIds = $request->roles;
        $roles = \Spatie\Permission\Models\Role::whereIn('id', $roleIds)->get();
        $user->syncRoles($roles);

        return redirect()->route('accounts.index')
            ->with('success', 'تم تحديث الحساب بنجاح');
    }

    /**
     * Remove the specified account.
     */
    public function destroy(User $user)
    {
        Gate::authorize('manage accounts');
        
        // Prevent deletion of the current user
        if ($user->id === auth()->id()) {
            return redirect()->route('accounts.index')
                ->with('error', 'لا يمكن حذف حسابك الشخصي');
        }

        $user->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'تم حذف الحساب بنجاح');
    }

    /**
     * Toggle account status (active/inactive).
     */
    public function toggleStatus(User $user)
    {
        Gate::authorize('manage accounts');
        
        // Prevent toggling current user's status
        if ($user->id === auth()->id()) {
            return redirect()->route('accounts.index')
                ->with('error', 'لا يمكن تغيير حالة حسابك الشخصي');
        }

        $user->update([
            'is_active' => !$user->is_active
        ]);

        $status = $user->is_active ? 'تفعيل' : 'إلغاء تفعيل';
        
        return redirect()->route('accounts.index')
            ->with('success', "تم {$status} الحساب بنجاح");
    }

    /**
     * Reset user password.
     */
    public function resetPassword(User $user)
    {
        Gate::authorize('manage accounts');
        
        $newPassword = 'password123'; // Default password
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return redirect()->route('accounts.index')
            ->with('success', "تم إعادة تعيين كلمة المرور إلى: {$newPassword}");
    }
}