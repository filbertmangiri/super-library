<?php

namespace App\Http\Requests;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!Auth::check()) {
            return false;
        }

        if (Review::firstWhere([
            'book_id' => $this->input('book_id'),
            'reviewer_id' => $this->input('reviewer_id')
        ])) {
            return false;
        }

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
            'book_id' => [
                'required'
            ],
            'reviewer_id' => [
                'required'
            ],
            'body' => [
                'required',
                'min:5',
                'max:1000'
            ]
        ];
    }
}
