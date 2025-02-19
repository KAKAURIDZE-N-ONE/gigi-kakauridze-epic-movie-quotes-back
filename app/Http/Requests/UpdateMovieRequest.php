<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'description.en' => ['required', 'regex:/^[A-Za-z0-9\s\p{P}]+$/u'],
			'description.ka' => ['required', 'regex:/^[\p{Georgian}0-9\s\p{P}]+$/u'],
			'director.en'    => ['required', 'regex:/^[A-Za-z0-9\s\p{P}]+$/u'],
			'director.ka'    => ['required', 'regex:/^[\p{Georgian}0-9\s\p{P}]+$/u'],
			'name.en'        => ['required', 'regex:/^[A-Za-z0-9\s\p{P}]+$/u'],
			'name.ka'        => ['required', 'regex:/^[\p{Georgian}0-9\s\p{P}]+$/u'],
			'year'           => 'required|integer|digits:4',
			'image'          => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:10240',
			'categories'     => 'required|array|min:1',
			'categories.*'   => 'integer|exists:categories,id',
		];
	}
}
