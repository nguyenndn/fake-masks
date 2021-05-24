<?php

namespace Modules\ObjectAppearance\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ObjectAppearance\Models\Camera;
use Modules\ObjectAppearance\Models\ObjectAppearance;
use Modules\ObjectAppearance\Models\Report;
use Modules\ObjectAppearance\Requests\CreateCameraRequest;
use Modules\ObjectAppearance\Requests\CreateObjectAppearanceRequest;

class ObjectAppearanceController extends Controller
{
    /**
     * @param CreateObjectAppearanceRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateObjectAppearanceRequest $request)
    {
        $object = ObjectAppearance::create(['name' => $request->object_name]);

        return $this->success($object, trans('messages.common.createSuccess'), ['isContainByDataString' => true]);
    }

    /**
     * @param CreateCameraRequest $request
     * @return \Illuminate\Http\Response
     */
    public function storeCamera(CreateCameraRequest $request)
    {
        $camera = Camera::create($request->all());
        
        return $this->success($camera, trans('messages.common.createSuccess'), ['isContainByDataString' => true]);
    }
    
    public function sync(Request $request)
    {
        $objectExist = ObjectAppearance::findOrFail($request->object_id);
        $report = [];
        if ($objectExist) {
            $data = $request->data;
            foreach ($data as $value) {
                $camera = Camera::findOrFail($value['camera_id']);

                if ($camera) {
                    foreach ($value['data'] as $item) {
                        $item = explode(',', $item);
                        $data = [
                            'people_entering' => $item[0],
                            'people_have_mask' => $item[1],
                            'people_no_mask' => $item[2],
                            'minutes' => $item[3],
                            'hours' => $item[4],
                            'date' => $item[5],
                            'month' => $item[6],
                            'year' => $item[7],
                            'camera_id' => $value['camera_id'],
                        ];

                        $report = Report::create($data);
                    }
                }
            }
        }
        
        return $this->success($report, trans('messages.common.createSuccess'), ['isContainByDataString' => true]);
    }
}
