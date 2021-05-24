<?php

namespace Modules\ObjectAppearance\Requests;

use Infrastructure\Requests\BaseCRUDRequest;
use Modules\ObjectAppearance\Models\ObjectAppearance;

class CreateCameraRequest extends BaseCRUDRequest
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
            'object_appearances_id' => 'required|exists:object_appearances,id',
            'name' => 'required',
        ];
    }
}
