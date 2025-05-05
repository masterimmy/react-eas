<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'organization_name' => ['required', 'string', 'max:255'],
            'organization_user_name' => ['required', 'string', 'max:255'],
            'organization_user_mobile' => ['required', 'string', 'max:20'],
            'organization_valid_from' => ['required', 'date'],
            'organization_valid_till' => ['required', 'date', 'after:organization_valid_from'],
            'organization_license_user_count' => ['required', 'integer', 'min:1'],
            'organization_timezone' => ['required', 'string', 'max:50'],
        ];

        // If updating (tenant ID exists in route)
        if ($this->route('tenant')) {
            $tenantId = $this->route('tenant')->id;
            
            $rules['organization_domain'] = [
                'required', 
                'string', 
                'max:255',
                Rule::unique('tenants', 'id')->ignore($tenantId)
            ];
            
            $rules['organization_user_email'] = [
                'required', 
                'email', 
                'max:255',
                Rule::unique('tenants', 'tenancy_db_email')->ignore($tenantId)
            ];
            
            // Make logo optional during update
            $rules['organization_logo'] = ['nullable', 'file', 'image', 'max:2048'];
        } else {
            // For create
            $rules['organization_domain'] = ['required', 'string', 'max:255', 'unique:tenants,id'];
            $rules['organization_user_email'] = ['required', 'email', 'max:255', 'unique:tenants,tenancy_db_email'];
            $rules['organization_logo'] = ['required', 'file', 'image', 'max:2048'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'organization_valid_till.after' => 'The subscription end date must be after the start date.',
            'organization_logo.max' => 'The logo must not be larger than 2MB.',
            'organization_domain.unique' => 'This domain is already registered.',
            'organization_user_email.unique' => 'This email is already registered.',
        ];
    }
}