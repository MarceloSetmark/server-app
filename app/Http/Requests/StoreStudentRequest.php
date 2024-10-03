<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'id_type' => 'required|integer',
            'id_number' => 'required|string|unique:students,id_number',
            'email' => 'required|email|unique:students,email',
            'phone_number' => 'required|integer',
            'address' => 'required|string',
            'profile_picture' => 'nullable|string',
            'obs' => 'nullable|string',
            'documents' => 'nullable|json',
            'user_id' => 'required|integer|min:1||unique:students,user_id',
        ];
    }
}
