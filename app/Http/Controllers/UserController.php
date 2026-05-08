<?php

namespace App\Http\Controllers;

use App\Jobs\CentralPullMasterJob;
use App\Jobs\CentralPushJob;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function loginView(Request $request)
    {
        if (Session::has('id_user')) {
            $role = Session::get('role');

            if ($role === 'admin') {
                return redirect('/admin/dashboard');
            }

            return redirect('/kasir');
        }

        return view('login');
    }

    public function loginProcess(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:100'],
            'password' => ['required', 'string', 'max:100'],
        ]);

        $username = trim($validated['username']);
        $password = $validated['password'];

        $user = User::query()
            ->where('username', $username)
            ->first();

        if (!$user) {
            return back()
                ->withErrors(['username' => 'Username tidak ditemukan.'])
                ->withInput();
        }

        if (!Hash::check($password, (string) $user->password)) {
            return back()
                ->withErrors(['password' => 'Password salah.'])
                ->withInput();
        }

        $request->session()->regenerate();

        Session::put('id_user', $user->id_user);
        Session::put('id_branch', $user->id_branch);
        Session::put('username', $user->username);
        Session::put('role', $user->role);
        Session::put('branch_name', Branch::query()->where('id_branch', $user->id_branch)->value('branch_name'));

        CentralPullMasterJob::dispatch()->afterResponse();
        CentralPushJob::dispatch((int) $user->id_branch)->afterResponse();

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        return redirect('/kasir');
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logout berhasil.');
    }
}
