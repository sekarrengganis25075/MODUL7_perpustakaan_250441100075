<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->can('akses-dashboard-admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->can('akses-dashboard-petugas')) {
            return redirect()->route('petugas.dashboard');
        }

        return view('dashboard.siswa', [
            'aktif' => $user->peminjamans()->with('buku')
                ->whereIn('status', [Peminjaman::DIAJUKAN, Peminjaman::DISETUJUI])->latest('id')->get(),
        ]);
    }

    public function admin()
    {
        return view('dashboard.admin', [
            'totalBuku' => Buku::count(),
            'totalUser' => User::count(),
            'menunggu'  => Peminjaman::where('status', Peminjaman::DIAJUKAN)->count(),
            'dipinjam'  => Peminjaman::where('status', Peminjaman::DISETUJUI)->count(),
        ]);
    }

    public function petugas()
    {
        return view('dashboard.petugas', [
            'totalBuku' => Buku::count(),
            'menunggu'  => Peminjaman::where('status', Peminjaman::DIAJUKAN)->count(),
            'dipinjam'  => Peminjaman::where('status', Peminjaman::DISETUJUI)->count(),
        ]);
    }
}