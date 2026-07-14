<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInventoryRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_name' => ['required', 'string', 'max:255'],
            'item_type' => ['required', Rule::in(['Product', 'Raw Material'])],
            'item_name' => ['required', 'string', 'max:255'],
            'quantity_in' => ['required', 'numeric'],
            'quantity_out' => ['required', 'numeric'],
            'damaged' => ['required', 'numeric'],
            'storage_location' => ['required', 'string', 'max:255'],
            'record_date' => ['required', 'date'],
        ];
    }
}
