<?php

namespace TypiCMS\Modules\Cases\Http\Controllers\Category;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Cases\Exports\Export;
use TypiCMS\Modules\Cases\Http\Requests\CategoryFormRequest;
use TypiCMS\Modules\Cases\Models\Casecategory;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('cases::admin.category.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' casecategories.xlsx';

        return Excel::download(new Export($request), $filename);
    }

    public function create(): View
    {
        $model = new Casecategory();

        return view('cases::admin.category.create')
            ->with(compact('model'));
    }

    public function edit(casecategory $casecategory): View
    {
        return view('cases::admin.category.edit')
            ->with(['model' => $casecategory]);
    }

    public function store(CategoryFormRequest $request): RedirectResponse
    {
        $casecategory = Casecategory::create($request->validated());

        return $this->redirect($request, $casecategory);
    }

    public function update(casecategory $casecategory, CategoryFormRequest $request): RedirectResponse
    {
        $casecategory->update($request->validated());

        return $this->redirect($request, $casecategory);
    }
}
