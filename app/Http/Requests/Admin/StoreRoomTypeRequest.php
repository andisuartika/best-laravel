<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomTypeRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'capacity' => 'required',
            'facilities' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'homestay.required' => 'Silahkan pilih penginapan!',
            'name.required' => 'Silahkan masukkan nama tipe kamar!',
            'description.required' => 'Silahkan masukkan deskripsi tipe kamar!',
            'capacity.required' => 'Silahkan masukkan kapasitas tipe kamar!',
            'facilities.required' => 'Silahkan masukkan fasilitas tipe kamar!',
        ];
    }
}
