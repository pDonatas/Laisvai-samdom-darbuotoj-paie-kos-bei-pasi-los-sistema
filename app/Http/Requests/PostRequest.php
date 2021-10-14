<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|unique:posts|min:5|max:100',
            'content' => 'required|string|min:5|max:2000',
            'category' => 'string|max:30',
            'price' => 'required|numeric|max:10000',
            'img' => 'sometimes|file|mimes:jpeg,bmp,png,gif,svg'
        ];

        if ($this->route()->getActionMethod() == 'update') {
            $rules['title'] = 'required|string|min:5|max:100';
        }

        return $rules;
    }
}
