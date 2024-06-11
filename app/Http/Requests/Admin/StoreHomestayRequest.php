<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreHomestayRequest extends FormRequest
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
            'address' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'manager' => 'required',
            'facilities' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Silahkan masukkan nama penginapan!',
            'description.required' => 'Silahkan masukkan deskripsi penginapan!',
            'address.required' => 'Silahkan masukkan lokasi penginapan!',
            'manager.required' => 'Silahkan pengelola penginapan!',
            'latitude.required' => 'Silahkan masukkan latitude!',
            'longitude.required' => 'Silahkan masukkan longitude!',
            'facilities.required' => 'Silahkan pilih fasilitas penginapan!',
        ];
    }
}
