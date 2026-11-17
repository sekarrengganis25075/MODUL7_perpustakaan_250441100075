<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BukuResource;
use App\Models\Buku;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $bukus = Buku::with('kategori')
            ->withCount('peminjamans')
            ->when($request->filled('cari'), function ($query) use ($request) {
                $cari = $request->query('cari');
                $like = $query->getConnection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
                $query->where(function ($q) use ($cari, $like) {
                    $q->where('judul', $like, "%{$cari}%")
                      ->orWhere('penulis', $like, "%{$cari}%")
                      ->orWhereHas('kategori', fn ($k) => $k->where('nama', $like, "%{$cari}%"));
                });
            })
            ->when($request->filled('kategori'), fn ($q) => $q->where('kategori_id', $request->query('kategori')))
            ->when($request->filled('tahun'), fn ($q) => $q->where('tahun_terbit', $request->query('tahun')))
            ->when(
                $request->query('urut') === 'asc',
                fn ($q) => $q->orderBy('id'),
                fn ($q) => $q->latest()->orderByDesc('id')
            )
            ->paginate(10)
            ->withQueryString();

        return response()->json([
            'message' => 'Daftar buku berhasil diambil',
            'data'    => BukuResource::collection($bukus->items())->resolve($request),
            'meta'    => [
                'current_page'  => $bukus->currentPage(),
                'last_page'     => $bukus->lastPage(),
                'per_page'      => $bukus->perPage(),
                'total'         => $bukus->total(),
                'next_page_url' => $bukus->nextPageUrl(),
                'prev_page_url' => $bukus->previousPageUrl(),
            ],
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate($this->rules(), $this->messages(), $this->attributes());

        $buku = Buku::create($data);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data'    => (new BukuResource($buku->load('kategori')))->resolve($request),
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $buku = Buku::with(['kategori', 'peminjamans'])->find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        return response()->json([
            'message' => 'Detail buku berhasil diambil',
            'data'    => (new BukuResource($buku))->resolve(),
        ], 200);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $data = $request->validate($this->rules(partial: true), $this->messages(), $this->attributes());

        $buku->update($data);

        return response()->json([
            'message' => 'Buku berhasil diperbarui',
            'data'    => (new BukuResource($buku->fresh('kategori')))->resolve($request),
        ], 200);
    }

    public function destroy(string $id): JsonResponse
    {
        $buku = Buku::find($id);

        if (! $buku) {
            return response()->json(['message' => 'not found'], 404);
        }

        $buku->peminjamans()->delete();
        $buku->delete();

        return response()->json(['message' => 'Buku berhasil dihapus'], 200);
    }


    private function rules(bool $partial = false): array
    {
        $rules = [
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['required', 'string', 'min:3', 'max:100', 'regex:/^[\pL\s.,\'\-]+$/u'],
            'tahun_terbit' => ['required', 'integer', 'between:1900,' . date('Y')],
            'deskripsi'    => ['nullable', 'string'],
        ];

        if ($partial) {
            $rules = array_map(fn ($r) => str_replace('required', 'sometimes', $r), $rules);
        }

        return $rules;
    }

    private function messages(): array
    {
        return [
            'required' => ':Attribute wajib diisi.',
            'string'   => ':Attribute harus berupa teks.',
            'integer'  => ':Attribute harus berupa bilangan bulat.',

            'kategori_id.exists' => 'Kategori yang dipilih tidak valid.',

            'judul.min' => 'Judul buku minimal :min karakter.',
            'judul.max' => 'Judul buku maksimal :max karakter.',

            'penulis.min' => 'Penulis minimal :min karakter.',
            'penulis.max' => 'Penulis maksimal :max karakter.',
            'penulis.regex' => 'Penulis hanya boleh berisi huruf, spasi, dan tanda baca (. , \' -).',

            'tahun_terbit.between' => 'Tahun terbit harus antara :min sampai :max.',
        ];
    }

    private function attributes(): array
    {
        return [
            'kategori_id'  => 'kategori',
            'judul'        => 'judul buku',
            'penulis'      => 'penulis',
            'tahun_terbit' => 'tahun terbit',
            'deskripsi'    => 'deskripsi',
        ];
    }
}