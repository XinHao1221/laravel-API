<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class BulkStoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            '*.name' => ['required'],
            '*.type' => ['required', Rule::in(['I', 'B'])],
            '*.email' => ['required', 'email'],
            '*.city' => ['required'],
            '*.postalCode' => ['required'],
            '*.country' => ['required'],
        ];
    }

    protected function prepareForValidation()
    {
        $data = [];

        foreach ($this->toArray() as $obj) {
            $obj['postal_code'] = $obj['postalCode'] ?? null;

            $data[] = $obj;
        }

        $this->merge($data);
    }
}
