<?php

namespace TypiCMS\Modules\Cases\Http\Requests;

use TypiCMS\Modules\Core\Http\Requests\AbstractFormRequest;

class CategoryFormRequest extends AbstractFormRequest
{
    public function rules()
    {
        return [
            'image_id' => 'nullable|integer',
            'title.*' => 'nullable|max:255',
            'slug.*' => 'nullable|alpha_dash|max:255|required_if:status.*,1|required_with:title.*',
            'status.*' => 'boolean',
            'body.*' => 'nullable',
            'meta_title.*'=>'nullable',
            'meta_keywords.*'=>'nullable',
            'meta_description.*'=>'nullable',

        ];
    }
}
