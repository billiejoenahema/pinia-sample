<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class IndexRequest extends FormRequest
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
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * ソート対象のカラム名を返す
     *
     * @return string|null
     */
    public function getSortColumn(): ?string
    {
        $key = $this->sort;
        $columns = [
            'name',
            'email',
            'phone',
            'birth_date',
        ];
        $column = Arr::first($columns, function ($value) use ($key) {
            return $value === $key;
        }, null);

        return $column;
    }

    /**
     * ソートの方向を返す
     *
     * @return string|null
     */
    public function getSortDirection(): ?string
    {
        return $this->ascending === 'true' ? 'asc' : 'desc';
    }
}
