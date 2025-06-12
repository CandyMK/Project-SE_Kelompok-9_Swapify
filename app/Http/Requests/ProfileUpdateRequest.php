<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules()
    {
        return [
            'photo' => ['nullable', 'image', 'max:2048'],
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['nullable', 'string', 'max:20'],

            'bio' => ['nullable', 'string', 'max:1000'],
            'location' => ['nullable', 'string', 'max:255'],
            'portfolio' => ['nullable', 'file', 'mimes:pdf', 'max:10240'], 
            'instagram' => ['nullable', 'url', 'max:255', 'regex:/^(https?:\/\/)?(www\.)?instagram\.com\/[A-Za-z0-9._%-]+\/?$/'],
            'facebook' => ['nullable', 'url', 'max:255', 'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/[A-Za-z0-9._%-]+\/?$/'],
            'twitter' => ['nullable', 'url', 'max:255', 'regex:/^(https?:\/\/)?(www\.)?(twitter\.com|x\.com)\/[A-Za-z0-9._%-]+\/?$/'],
        ];
    }

    public function messages()
    {
        return [
            'instagram.regex' => 'The Instagram URL must be a valid Instagram profile link',
            'facebook.regex' => 'The Facebook URL must be a valid Facebook profile link',
            'twitter.regex' => 'The Twitter URL must be a valid Twitter/X profile link',
        ];
    }
}
