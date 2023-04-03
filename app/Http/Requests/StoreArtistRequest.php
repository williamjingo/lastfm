<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArtistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:artists,name|min:3|max:255',
            'listners' => 'integer',
            'image' => 'url|max:255',
            'url' => 'url|max:255',
            'mbid' => 'string|max:255',
            'streamable' => 'integer',
        ];
    }

    /**
     * Adding custom rule message
     * @return string[]
     */
    public function messages()
    {
        return [
            'name.unique' => 'Artist has already been added to your Favourites'
        ];
    }
}
