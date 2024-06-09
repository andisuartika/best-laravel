<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDestinationRequest extends FormRequest
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
            'categories' => 'required',
            'facilities' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Silahkan masukkan nama destinasi!',
            'description.required' => 'Silahkan masukkan deskripsi destinasi!',
            'address.required' => 'Silahkan masukkan lokasi destinasi!',
            'manager.required' => 'Silahkan masukkan pengelola destinasi!',
            'categories.required' => 'Silahkan masukkan kategori destinasi!',
            'latitude.required' => 'Silahkan masukkan latitude!',
            'longitude.required' => 'Silahkan masukkan longitude!',
            'facilities.required' => 'Silahkan masukkan fasilitas destinasi!',
        ];
    }
}
