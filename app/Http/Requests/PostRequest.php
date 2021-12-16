<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;

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
            'category' => 'required|integer|max:30',
            'price' => 'required|numeric|max:10000',
            'img' => 'file|mimes:jpeg,bmp,png,gif,svg'
        ];

        /** @var Route $route */
        $route = $this->route();

        if ($route->getActionMethod() == 'update') {
            $rules['title'] = 'required|string|min:5|max:100';
        }

        return $rules;
    }
}
