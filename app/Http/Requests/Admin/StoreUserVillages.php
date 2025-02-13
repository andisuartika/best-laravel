<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserVillages extends FormRequest
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
            'village' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|unique:users,phone',
            'address' => 'required',
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'village.required' => 'Silahkan pilih desa',
            'name.required' => 'Silahkan nama pengelola desa wisata',
            'email.required' => 'Silahkan masukkan alamat email',
            'email.unique' => 'Alamat email sudah terdaftar',
            'phone.required' => 'Silahkan masukkan nomor telp',
            'phone.unique' => 'Nomor Telp sudah terdaftar',
            'address.required' => 'Silahkan masukkan alamat',
            'password.confirmed' => 'Password tidak sama',
            'password.min' => 'Password minimal 6 karakter',
        ];
    }
}
