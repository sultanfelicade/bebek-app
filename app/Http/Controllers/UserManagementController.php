<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = DB::table('m_users as u')
            ->leftJoin('m_branches as b', 'b.id_branch', '=', 'u.id_branch')
            ->select([
                'u.id_user',
                'u.id_branch',
                'u.username',
                'u.role',
                'b.branch_name',
            ])
            ->orderBy('u.id_user', 'desc')
            ->get();

        return view('master.users.index', compact('users'));
    }

    public function create()
    {
        $branches = Branch::query()->orderBy('id_branch')->get();
        return view('master.users.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:m_users,username'],
            'password' => ['required', 'string', 'min:4', 'max:100'],
            'id_branch' => ['required', 'integer', 'exists:m_branches,id_branch'],
            'role' => ['required', 'in:admin,kasir'],
        ]);

        User::query()->create([
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'id_branch' => (int) $validated['id_branch'],
            'role' => $validated['role'],
        ]);

        return redirect('/master/users')->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $user = User::query()->where('id_user', $id)->firstOrFail();
        $branches = Branch::query()->orderBy('id_branch')->get();
        return view('master.users.edit', compact('user', 'branches'));
    }

    public function update(Request $request, int $id)
    {
        $user = User::query()->where('id_user', $id)->firstOrFail();

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:m_users,username,' . $user->id_user . ',id_user'],
            'new_password' => ['nullable', 'string', 'min:4', 'max:100'],
            'id_branch' => ['required', 'integer', 'exists:m_branches,id_branch'],
            'role' => ['required', 'in:admin,kasir'],
        ]);

        $update = [
            'username' => $validated['username'],
            'id_branch' => (int) $validated['id_branch'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['new_password'])) {
            $update['password'] = Hash::make($validated['new_password']);
        }

        $user->update($update);

        return redirect('/master/users')->with('success', 'Pengguna berhasil diperbarui.');
    }
}
