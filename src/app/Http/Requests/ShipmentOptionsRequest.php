<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ShipmentOptionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function wantsJson(): bool
    {
        return true;
    }

    /**
     * Normalize input before validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('country')) {
            $this->merge([
                // Normalize countries as uppercase (e.g., NL, BE, FR)
                'country' => strtoupper($this->input('country')),
            ]);
        }

        if ($this->has('package_type')) {
            $this->merge([
                // Normalize package type (e.g., Standard, Mailbox, Pallet)
                'package_type' => ucfirst(strtolower($this->input('package_type'))),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        return [
            'country'       => ['nullable', 'string', 'size:2', 'exists:countries,code'],
            'shipment_date' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:today'],
            'package_type'  => ['nullable', 'string', 'exists:packages,name'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (
                !$this->filled('country') &&
                !$this->filled('shipment_date') &&
                !$this->filled('package_type')
            ) {
                $validator->errors()->add('parameters', 'At least one parameter must be provided.');
            }
        });
    }

    /**
     * Ensure validation errors always return JSON (422).
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
