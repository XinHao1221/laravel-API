<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
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
        // Check the HTTP method
        $method = $this->method();

        // Handle PUT request
        if ($method == 'PUT') {
            return [
                'name' => ['required'],
                'type' => ['required', Rule::in(['I', 'B'])],
                'email' => ['required', 'email'],
                'city' => ['required'],
                'postalCode' => ['required'],
                'country' => ['required'],
            ];
        } else {
            // Handle patch request
            return [
                'name' => ['sometimes', 'required'],
                'type' => ['sometimes', 'required', Rule::in(['I', 'B'])],
                'email' => ['sometimes', 'required', 'email'],
                'city' => ['sometimes', 'required'],
                'postalCode' => ['sometimes', 'required'],
                'country' => ['sometimes', 'required'],
            ];
        }
    }

    // transform the variable from client to the data type that match with database's column
    protected function prepareForValidation()
    {
        // Check if postal_code exists inside the request 
        if ($this->postalCode) {
            $this->merge([
                'postal_code' => $this->postalCode,
            ]);
        }
    }
}
