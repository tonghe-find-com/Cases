<?php

namespace TypiCMS\Modules\Cases\Http\Controllers\Category;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use TypiCMS\Modules\Core\Filters\FilterOr;
use TypiCMS\Modules\Core\Http\Controllers\BaseApiController;
use TypiCMS\Modules\Cases\Models\Casecategory;

class ApiController extends BaseApiController
{
    public function index(Request $request): LengthAwarePaginator
    {
        $data = QueryBuilder::for(Casecategory::class)
            ->selectFields($request->input('fields.casecategories'))
            ->allowedSorts(['status_translated', 'title_translated','position'])
            ->allowedFilters([
                AllowedFilter::custom('title', new FilterOr()),
            ])
            ->allowedIncludes(['image'])
            ->paginate($request->input('per_page'));

        return $data;
    }

    protected function updatePartial(Casecategory $casecategory, Request $request)
    {
        foreach ($request->only('status','position') as $key => $content) {
            if ($casecategory->isTranslatableAttribute($key)) {
                foreach ($content as $lang => $value) {
                    $casecategory->setTranslation($key, $lang, $value);
                }
            } else {
                $casecategory->{$key} = $content;
            }
        }

        $casecategory->save();
    }

    public function destroy(Casecategory $casecategory)
    {
        $casecategory->delete();
    }
}
