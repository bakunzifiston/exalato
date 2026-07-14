<?php

namespace App\Http\Requests\Admin;

use App\Support\RwandaLocations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $districts = array_keys(RwandaLocations::districtsFor($this->input('province')));

        return [
            'employee_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('employees', 'employee_id')->ignore($this->route('employee')),
            ],
            'name' => ['required', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'province' => ['nullable', 'string', Rule::in(array_keys(RwandaLocations::provinces()))],
            'district' => ['required', 'string', Rule::in($districts)],
        ];
    }
}
