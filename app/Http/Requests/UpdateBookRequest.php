<?php

namespace App\Http\Requests;

use Illuminate\Database\Schema\Builder;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
        return [
            'title' => [
                'required',
                'unique:books,title,' . $this->book->id,
                'min:5',
                'max:' . Builder::$defaultStringLength
            ],
            'author_id' => [
                'required',
                'numeric'
            ],
            'category_id' => [
                'required',
                'numeric'
            ],
            'image' => [
                'image',
                'file',
                'max:4096'
            ],
            'synopsis' => [
                'required',
                'min:5',
                'max:' . Builder::$defaultStringLength
            ]
        ];
    }
}
