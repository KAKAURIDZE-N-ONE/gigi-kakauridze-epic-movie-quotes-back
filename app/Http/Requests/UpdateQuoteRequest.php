<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'quote.en' => ['required', 'regex:/^[A-Za-z0-9\s\p{P}]+$/u'],
			'quote.ka' => ['required', 'regex:/^[\p{Georgian}0-9\s\p{P}]+$/u'],
			'movie_id' => ['required'],
			'image'    => 'file|mimes:jpeg,png,jpg,gif,svg|max:10240',
		];
	}
}
