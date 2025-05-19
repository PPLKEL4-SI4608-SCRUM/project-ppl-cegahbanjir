<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class HandleUsersController extends Controller
{
    public function index()
    {
        $data_user = User::where('role', 'user')->latest()->paginate(10); 

        return view('admin.pengguna.index', compact('data_user'));
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->role !== 'user') {
            return redirect()->route('admin.pengguna.index')->with('error', 'Tidak dapat menghapus akun ini.');
        }

        $user->delete();

        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
