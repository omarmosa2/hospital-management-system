@extends('layouts.app')

@section('title', __('manage_accounts_system'))

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-slate-100">{{ __('manage_accounts_system') }}</h1>
            <p class="text-gray-600 dark:text-slate-400 mt-2">{{ __('manage_all_user_accounts') }}</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('accounts.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white rounded-lg hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors duration-200 mr-3">
                <i class="fas fa-plus mr-2"></i>
                {{ __('create_new_account') }}
            </a>
            <button onclick="exportAccounts()" class="inline-flex items-center px-4 py-2 bg-green-600 dark:bg-green-700 text-white rounded-lg hover:bg-green-700 dark:hover:bg-green-600 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                {{ __('export_data') }}
            </button>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex-1 md:mr-6">
                <div class="relative">
                    <input type="text" placeholder="{{ __('search_for_account') }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100 placeholder-gray-400 dark:placeholder-slate-400">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400 dark:text-slate-400"></i>
                </div>
            </div>
            <div class="flex space-x-4">
                <select class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                    <option>{{ __('all') }} {{ __('roles') }}</option>
                    <option>{{ __('role_admin') }}</option>
                    <option>{{ __('role_doctor') }}</option>
                    <option>{{ __('role_nurse') }}</option>
                    <option>{{ __('role_receptionist') }}</option>
                    <option>{{ __('role_patient') }}</option>
                </select>
                <select class="px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-slate-700 text-gray-900 dark:text-slate-100">
                    <option>{{ __('all_statuses') }}</option>
                    <option>{{ __('active') }}</option>
                    <option>{{ __('inactive') }}</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Accounts Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg dark:shadow-slate-900 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-slate-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-slate-100">{{ __('accounts_list') }}</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('user') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('email') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('role') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('password') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('status') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('created_at') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-slate-300 uppercase tracking-wider">{{ __('actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-sm font-bold">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="mr-4">
                                        <div class="text-sm font-medium text-gray-900 dark:text-slate-100">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-slate-400">ID: {{ $user->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($role->name == 'Admin') bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200
                                        @elseif($role->name == 'Doctor') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                        @elseif($role->name == 'Nurse') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                        @elseif($role->name == 'Receptionist') bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                        @elseif($role->name == 'Patient') bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200
                                        @else bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200
                                        @endif">
                                        @if($role->name == 'Admin') {{ __('role_admin') }}
                                        @elseif($role->name == 'Doctor') {{ __('role_doctor') }}
                                        @elseif($role->name == 'Nurse') {{ __('role_nurse') }}
                                        @elseif($role->name == 'Receptionist') {{ __('role_receptionist') }}
                                        @elseif($role->name == 'Patient') {{ __('role_patient') }}
                                        @else {{ $role->name }}
                                        @endif
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <input type="password"
                                           value="••••••••"
                                           class="text-sm font-mono bg-gray-100 dark:bg-slate-700 text-gray-900 dark:text-slate-100 border-0 rounded px-2 py-1 w-24"
                                           readonly>
                                    <button onclick="showPassword({{ $user->id }})"
                                            class="mr-2 text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300"
                                            title="{{ __('show_password') }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200' }}">
                                    <i class="fas fa-circle text-xs mr-1"></i>
                                    {{ $user->is_active ? __('active') : __('inactive') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-slate-100">
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('accounts.edit', $user) }}" 
                                       class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300" 
                                       title="{{ __('edit') }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('accounts.toggleStatus', $user) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-yellow-600 dark:text-yellow-400 hover:text-yellow-900 dark:hover:text-yellow-300" 
                                                title="{{ $user->is_active ? __('deactivate') : __('activate') }}">
                                            <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>
                                    
                                    <form action="{{ route('accounts.resetPassword', $user) }}" 
                                          method="POST" 
                                          class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300" 
                                                title="{{ __('reset_password') }}"
                                                onclick="return confirm('{{ __('confirm_reset_password') }}')">
                                            <i class="fas fa-key"></i>
                                        </button>
                                    </form>
                                    
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('accounts.destroy', $user) }}" 
                                              method="POST" 
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300" 
                                                    title="{{ __('delete') }}"
                                                    onclick="return confirm('{{ __('confirm_delete_account') }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-users text-gray-300 dark:text-slate-600 text-4xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100 mb-2">{{ __('no_accounts') }}</h3>
                                    <p class="text-gray-500 dark:text-slate-400">{{ __('no_accounts_found') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 shadow-lg dark:shadow-slate-900">
            {{ $users->links() }}
        </div>
    @endif
</div>

<!-- Password Modal -->
<div id="passwordModal" class="fixed inset-0 bg-gray-600 dark:bg-slate-900 bg-opacity-50 dark:bg-opacity-70 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border border-gray-200 dark:border-slate-700 w-96 shadow-lg rounded-md bg-white dark:bg-slate-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-slate-100">{{ __('password') }}</h3>
                <button onclick="closePasswordModal()" class="text-gray-400 dark:text-slate-400 hover:text-gray-600 dark:hover:text-slate-300">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-2">{{ __('current_password') }}</label>
                <input type="text" id="passwordValue" readonly
                       class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-100 dark:bg-slate-700 text-gray-900 dark:text-slate-100 font-mono">
            </div>
            <div class="flex justify-end">
                <button onclick="closePasswordModal()" class="px-4 py-2 bg-gray-300 dark:bg-slate-600 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-400 dark:hover:bg-slate-500">
                    {{ __('close') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showPassword(userId) {
    // In a real application, you would fetch the password from the server
    // For security reasons, we'll show a placeholder
    document.getElementById('passwordValue').value = '•••••••• ({{ __('encrypted') }})';
    document.getElementById('passwordModal').classList.remove('hidden');
}

function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
}

function exportAccounts() {
    // In a real application, you would implement CSV/Excel export
    alert('{{ __('export_data_soon') }}');
}
</script>
@endsection
