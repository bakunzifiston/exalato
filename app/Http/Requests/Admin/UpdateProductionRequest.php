<?php

namespace App\Http\Requests\Admin;

use App\Support\Barcodes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'batch_id' => ['required', 'string', 'max:255'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity_produced' => ['required', 'numeric'],
            'damaged' => ['required', 'numeric'],
            'raw_materials_used' => ['nullable', 'string'],
            'production_date' => ['required', 'date'],
            'responsible_staff' => ['nullable', 'string', 'max:255'],
            'barcode' => ['required', Rule::in(array_keys(Barcodes::options()))],
            'quality_control_notes' => ['nullable', 'string'],
        ];
    }
}
