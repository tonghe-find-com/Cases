<?php

namespace TypiCMS\Modules\Cases\Http\Controllers\Item;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Cases\Models\Caseitem;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Caseitem::class)
            ->selectFields($request->input('fields.cases'))
            ->allowedSorts(['status_translated', 'title_translated','position'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Caseitem $case, Request $request)
    {
        foreach ($request->only('status','position') as $key => $content) {
            if ($case->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $case->setTranslation($key, $lang, $value);
                }
            } else {
                $case->{$key} = $content;
            }
        }

        $case->save();
    }

    public function destroy(Caseitem $case)
    {
        $case->delete();
    }
}
