<?php

namespace Modules\ObjectAppearance\Requests;

use Infrastructure\Requests\BaseCRUDRequest;
use Modules\ObjectAppearance\Models\ObjectAppearance;

class CreateObjectAppearanceRequest extends BaseCRUDRequest
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
            'object_name' => [
                'required',
                'string',
                function ($attribute, $value, $fail){
                    $exist = ObjectAppearance::where('name', $value)->first();

                    if (!$exist) {
                        return true;
                    }
                    return $fail("Tên đã tồn tại ");
                },
            ],
        ];
    }
}
