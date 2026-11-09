<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_id'  => ['required', 'exists:kategoris,id'],
            'judul'        => ['required', 'string', 'min:3', 'max:150'],
            'penulis'      => ['required', 'string', 'min:3', 'max:100'],
            'tahun_terbit' => ['required', 'integer', 'between:1900,' . date('Y')],
            'deskripsi'    => ['nullable', 'string'],
        ];
    }

    public function messages(): array
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

            'tahun_terbit.between' => 'Tahun terbit harus antara :min sampai :max.',
        ];
    }

    public function attributes(): array
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