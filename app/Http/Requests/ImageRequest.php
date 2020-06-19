<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location_id' => 'nullable|numeric',
            'date' => 'nullable|date',
            'file' => 'required|image',
        ];
    }

    public function messages()
    {
      return [
        'name.required' => 'Вы не дали название для фотографии!',
        'file.required' => 'Файл не выбран',
        'name.max' => 'Длина названия не должна превышать 255 символов',
        'file.image' => 'Файл должен быть картинкой или изображением или фотографией'
      ];
    }
}
