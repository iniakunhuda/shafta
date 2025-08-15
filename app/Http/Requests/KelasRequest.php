<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KelasRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'maksimum' => 'required|integer|min:1',
            'wali_kelas_nama' => 'required|string|max:255',
            'id_tahunajaran' => 'required|exists:tahun_ajaran,id',
            'jenjang' => 'required|string|in:SD,SMP,SMA,SMK',
        ];
    }
}
