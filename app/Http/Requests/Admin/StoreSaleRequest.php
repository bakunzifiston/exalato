<?php

namespace App\Http\Requests\Admin;

use App\Support\Barcodes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSaleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_Phone' => ['nullable', 'string', 'max:255'],
            'product_id' => ['required', 'exists:products,id'],
            'production_id' => [
                'required',
                'exists:productions,id',
                Rule::exists('productions', 'id')->where(function ($query) {
                    $query->where('product_id', $this->input('product_id'))
                        ->where('quantity_produced', '>', 0);
                }),
            ],
            'quantity_sold' => ['required', 'numeric'],
            'selling_price' => ['required', 'numeric'],
            'total_revenue' => ['required', 'numeric'],
            'payment_status' => ['required', Rule::in(['Paid', 'Pending', 'Credit'])],
            'delivery_status' => ['required', Rule::in(['Delivered', 'Pending', 'In Transit'])],
            'sales_channel' => ['required', Rule::in(['Momo Pay', 'Card', 'Cash'])],
            'barcode' => ['required', Rule::in(array_keys(Barcodes::options()))],
            'invoice_number' => ['nullable', 'string', 'max:255'],
            'sale_date' => ['required', 'date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $qty = $this->input('quantity_sold');
        $price = $this->input('selling_price');

        if (is_numeric($qty) && is_numeric($price)) {
            $this->merge([
                'total_revenue' => $qty * $price,
            ]);
        }
    }
}
