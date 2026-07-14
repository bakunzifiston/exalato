<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->latest();

        if ($search = $request->string('search')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('verified')) {
            $request->string('verified')->toString() === '1'
                ? $query->whereNotNull('email_verified_at')
                : $query->whereNull('email_verified_at');
        }

        $kpis = [
            [
                'label' => 'Users',
                'value' => (string) User::count(),
                'description' => 'Admin accounts',
            ],
            [
                'label' => 'Verified',
                'value' => (string) User::whereNotNull('email_verified_at')->count(),
                'description' => 'Email confirmed',
            ],
            [
                'label' => 'Pending',
                'value' => (string) User::whereNull('email_verified_at')->count(),
                'description' => 'Awaiting verification',
            ],
            [
                'label' => 'This month',
                'value' => (string) User::where('created_at', '>=', now()->startOfMonth())->count(),
                'description' => 'New accounts',
            ],
        ];

        return view('admin.users.index', [
            'users' => $query->paginate(15)->withQueryString(),
            'kpis' => $kpis,
            'verifiedOptions' => [
                '1' => 'Verified',
                '0' => 'Pending',
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        $ids = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:users,id'],
        ])['ids'];

        User::whereIn('id', $ids)->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Selected users deleted successfully.');
    }
}
