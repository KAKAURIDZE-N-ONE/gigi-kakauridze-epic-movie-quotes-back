<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'token'                 => 'required',
			'email'                 => 'required|email',
			'password'              => 'required|min:8|max:15|confirmed',
			'password_confirmation' => 'required',
		];
	}
}
