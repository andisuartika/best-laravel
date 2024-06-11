<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransportationRequest extends FormRequest
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
            'manager' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required',
            'extra_price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'manager.required' => 'Silahkan pilih pengelola!',
            'name.required' => 'Silahkan masukkan nama tipe kamar!',
            'description.required' => 'Silahkan masukkan deskripsi tipe kamar!',
            'capacity.required' => 'Silahkan masukkan kapasitas tipe kamar!',
            'facilities.required' => 'Silahkan masukkan fasilitas tipe kamar!',
        ];
    }
}
