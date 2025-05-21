<?php

namespace App\Http\Controllers;
use App\Models\Pengepul;
use App\Models\Iklan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function proseslogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->username;
        $password = $request->password;

        if ($username === 'admin' && $password === 'admin01') {
            // Set session secara manual
            session([
                'user_id' => 1,
                'user_role' => 'admin',
                'username' => 'admin'
            ]);

            return redirect()->route('dashboard.admin');
        } else {
            return back()->withErrors(['Hanya admin dengan username dan password yang benar yang diizinkan masuk.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        return redirect('/');
    }

    public function dashboard()
{
    if (session('user_role') !== 'admin') {
        return redirect('/')->withErrors(['Anda tidak memiliki akses.']);
    }

    $avgPerMonth = Pengepul::selectRaw('MONTH(created_at) as bulan, AVG(harga) as rata_harga')
        ->whereYear('created_at', date('Y'))
        ->groupByRaw('MONTH(created_at)')
        ->get();

    $totalPengepul = Pengepul::distinct('id')->count('id');
    $totalIklan = Iklan::count(); // Menambahkan jumlah iklan

    return view('admin.layouts.dashboard', [
        'title' => 'Dashboard',
        'avgPerMonth' => $avgPerMonth,
        'totalPengepul' => $totalPengepul,
        'totalIklan' => $totalIklan,
    ]);
}
}
