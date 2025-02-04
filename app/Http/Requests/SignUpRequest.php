<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'name'                  => 'required|min:3|max:15|lowercase|unique:users',
			'email'                 => 'email|required|unique:users',
			'password'              => 'required|min:8|max:15|lowercase|confirmed',
			'password_confirmation' => 'required',
		];
	}
}
