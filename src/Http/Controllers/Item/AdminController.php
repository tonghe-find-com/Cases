<?php

namespace TypiCMS\Modules\Cases\Http\Controllers\Item;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use TypiCMS\Modules\Core\Http\Controllers\BaseAdminController;
use TypiCMS\Modules\Cases\Exports\Export;
use TypiCMS\Modules\Cases\Http\Requests\FormRequest;
use TypiCMS\Modules\Cases\Models\Caseitem;

class AdminController extends BaseAdminController
{
    public function index(): View
    {
        return view('cases::admin.item.index');
    }

    public function export(Request $request)
    {
        $filename = date('Y-m-d').' '.config('app.name').' cases.xlsx';

        return Excel::download(new Export($request), $filename);
    }

    public function create(): View
    {
        $model = new Caseitem();

        return view('cases::admin.item.create')
            ->with(compact('model'));
    }

    public function edit(Caseitem $case): View
    {
        return view('cases::admin.item.edit')
            ->with(['model' => $case]);
    }

    public function store(FormRequest $request): RedirectResponse
    {
        $case = Caseitem::create($request->validated());

        return $this->redirect($request, $case);
    }

    public function update(Caseitem $case, FormRequest $request): RedirectResponse
    {
        $case->update($request->validated());

        return $this->redirect($request, $case);
    }
}
