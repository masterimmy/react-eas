<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_name' => ['required', 'string', 'max:255'],
            'organization_domain' => ['required', 'string', 'max:255', 'unique:tenants,id'],
            'organization_user_name' => ['required', 'string', 'max:255'],
            'organization_user_mobile' => ['required', 'string', 'max:20'],
            'organization_user_email' => ['required', 'email', 'max:255', 'unique:tenants,tenancy_db_email'],
            'organization_valid_from' => ['required', 'date'],
            'organization_valid_till' => ['required', 'date', 'after:organization_valid_from'],
            'organization_license_user_count' => ['required', 'integer', 'min:1'],
            'organization_timezone' => ['required', 'string', 'max:50'],
            'organization_logo' => ['required', 'file', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'organization_valid_till.after' => 'The subscription end date must be after the start date.',
            'organization_logo.max' => 'The logo must not be larger than 2MB.',
            'organization_domain.unique' => 'This domain is already registered.',
        ];
    }
}