<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\UserRegistrationDocuments;
use App\Models\ClientPreference;
use Illuminate\Validation\Rule;

class SignupRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {

        $preferences = ClientPreference::first();
        $user_registration_documents = UserRegistrationDocuments::with('primary')->get();
        $rules = [
            'name' => 'required|min:3|max:50',
            'password' => 'required|string|min:6|max:50|confirmed',
            'device_type' => 'required|string',
            'device_token' => 'required|string',
            'term_and_condition' => 'accepted',
            'refferal_code' => 'nullable|exists:user_refferals,refferal_code',
        ];

        $rules['email'] = ['email', 'unique:users,email'];

        $rules['phone_number'][] = Rule::unique('users')
            ->where('phone_number', $this->input('phone_number'))
            ->where('dial_code',    $this->input('dialCode'));

        if ($preferences->verify_email == 1) {
            $rules['email'][] = 'required';
        };

        if ($preferences->verify_phone == 1) {
            $rules['phone_number'][] = 'required';
            $rules['dialCode']       = 'required';
        }

        if (!($this->has('email') || $this->has('phone_number'))) {
            if (!in_array('required', $rules['phone_number'])) $rules['phone_number'][] = 'required';
            if (!in_array('required', $rules['email']))        $rules['email'][] = 'required';

            $rules['dialCode'] = 'required';
        }

        foreach ($user_registration_documents as $user_registration_document) {
            if ($user_registration_document->is_required == 1) {
                $rules[$user_registration_document->primary->slug] = 'required';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            "name.required" => __('The name field is required.'),
            "email.required" => __('The email field is required.'),
            "email.unique" => __('The email has already been taken.'),
            "name.min" => __('The name must be at least 3 characters.'),
            "password.required" => __("The password field is required."),
            "name.max" => __('The name may not be greater than 50 characters.'),
            "phone_number.required" => __('The phone number field is required.'),
            "phone_number.unique" => __('The phone number has already been taken.'),
            "term_and_condition.required" => __('The term and condition must be accepted.'),
            "password_confirmation.confirmed" => __('The password confirmation does not match.'),
        ];
    }
}
