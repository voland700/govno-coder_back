<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'name.required' => 'Поле "Навание" обязательно для заполнения',
            'sort.integer' => 'Номер сортровки должен быть целым числом',
            'img.image' => 'Основное изображение - должно быть файлом c изображением',
            'img.mimes' => 'Фал с изображением должен иметь расширение: jpeg,jpg,bmp,png',
            'img.size' => 'Размер изображения логотипа не должен превышать 2 мб.'
        ];
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'sort' => 'integer|nullable',
            'img' => 'image|mimes:jpeg,jpg,bmp,png|nullable',
            'img.size' => '2048|nullable'
        ];
    }
}
