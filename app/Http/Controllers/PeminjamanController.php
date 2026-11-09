<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate(['buku_id' => ['required', 'exists:bukus,id']]);

        $sudah = Peminjaman::where('user_id', $request->user()->id)
            ->where('buku_id', $data['buku_id'])
            ->whereIn('status', [Peminjaman::DIAJUKAN, Peminjaman::DISETUJUI])->exists();
        if ($sudah) {
            return back()->withErrors(['buku_id' => 'Anda sudah mengajukan atau sedang meminjam buku ini.']);
        }

        Peminjaman::create([
            'user_id' => $request->user()->id,
            'buku_id' => $data['buku_id'],
            'status'  => Peminjaman::DIAJUKAN,
        ]);

        return redirect()->route('peminjaman.saya')->with('status', 'Pengajuan peminjaman dikirim.');
    }

    public function saya(Request $request)
    {
        $list = $request->user()->peminjamans()->with('buku')
            ->whereIn('status', [Peminjaman::DIAJUKAN, Peminjaman::DISETUJUI])->latest('id')->get();

        return view('peminjaman.saya', compact('list'));
    }

    public function riwayat(Request $request, ?User $user = null)
    {
        $me = $request->user();
        $target = $user ?? $me;

        abort_unless($target->id === $me->id || $me->can('kelola-peminjaman'), 403);

        $list = $target->peminjamans()->with('buku')->latest('id')->paginate(15);

        return view('peminjaman.riwayat', ['list' => $list, 'target' => $target]);
    }

    public function kelola()
    {
        $list = Peminjaman::with(['user', 'anggota', 'buku'])->latest('id')->paginate(15);

        return view('peminjaman.kelola', compact('list'));
    }

    public function setujui(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::DIAJUKAN) {
            return back()->withErrors(['status' => 'Pengajuan ini sudah diproses.']);
        }

        $sedangDipinjam = Peminjaman::where('buku_id', $peminjaman->buku_id)
            ->where('status', Peminjaman::DISETUJUI)->exists();
        if ($sedangDipinjam) {
            return back()->withErrors(['status' => 'Buku sedang dipinjam pengguna lain.']);
        }

        $peminjaman->update([
            'status' => Peminjaman::DISETUJUI,
            'tanggal_pinjam' => now()->toDateString(),
        ]);

        return back()->with('status', 'Peminjaman disetujui.');
    }

    public function tolak(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::DIAJUKAN) {
            return back()->withErrors(['status' => 'Pengajuan ini sudah diproses.']);
        }
        $peminjaman->update(['status' => Peminjaman::DITOLAK]);

        return back()->with('status', 'Pengajuan ditolak.');
    }

    public function pengembalian()
    {
        $list = Peminjaman::with(['user', 'anggota', 'buku'])
            ->whereIn('status', [Peminjaman::DISETUJUI, Peminjaman::DIKEMBALIKAN])->latest('id')->paginate(15);

        return view('peminjaman.pengembalian', compact('list'));
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== Peminjaman::DISETUJUI) {
            return back()->withErrors(['status' => 'Buku ini tidak sedang dipinjam.']);
        }

        $peminjaman->update([
            'status' => Peminjaman::DIKEMBALIKAN,
            'tanggal_kembali' => now()->toDateString(),
        ]);

        return back()->with('status', 'Pengembalian dicatat.');
    }
}