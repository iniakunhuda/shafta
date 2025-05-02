<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UserSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ],
            'status' => ['required', Rule::in(['active', 'pending', 'block'])],
            'status_message' => 'nullable|string|max:255',
            'role' => 'required|string|max:255',
        ];

        // Add unique email rule for store (create)
        if ($this->isMethod('post')) {
            $rules['email'][] = 'unique:users';
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        // Add unique email rule for update, except the current user
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['email'][] = Rule::unique('users')->ignore($this->route('siswa'));
            // Password tidak perlu diisi karena tidak diubah
            $rules['password'] = ['nullable', 'confirmed', Password::defaults()];
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nama.required' => 'Nama harus diisi.',
            'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'status.required' => 'Status harus diisi.',
            'status.in' => 'Status tidak valid.',
        ];
    }
}
