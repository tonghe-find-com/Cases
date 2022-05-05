<?php

namespace TypiCMS\Modules\Cases\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use TypiCMS\Modules\Cases\Models\Casecategory;
use TypiCMS\Modules\Core\Http\Controllers\BasePublicController;
use TypiCMS\Modules\Cases\Models\Caseitem;

class PublicController extends BasePublicController
{
    public function index()
    {
        $model = Casecategory::published()->firstOrFail();
        return redirect($model->url());
    }

    public function show($slug,Request $request)
    {
        $area = $request->area ?? '';
        $model = Casecategory::published()->whereSlugIs($slug)->firstOrFail();
        $list = Caseitem::published()->where('category_id',$model->id)->orderBy('position','ASC')->get();
        if(count($list)==0){
            $area_list = [];
        }else{
            $area_list = Casecategory::getAreaList($list);
        }

        return view('cases::public.index')
            ->with(compact('model','list','area_list','area'));
    }
}
