<?php

namespace TypiCMS\Modules\Cases\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Traits\HasFiles;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Cases\Presenters\ModulePresenter;

class Caseitem extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;

    public $table = "cases";

    protected $presenter = ModulePresenter::class;

    protected $guarded = [];

    public $translatable = [
        'title',
        'sub_title',
        'slug',
        'status',
        'summary',
        'body',
        'tag1',
        'tag2',
        'meta_title',
        'meta_keywords',
        'meta_description',
    ];

    public function getThumbAttribute(): string
    {
        return $this->present()->image(null, 54);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(File::class, 'image_id');
    }

    public function category()
    {
        return $this->belongsTo(Casecategory::class,'category_id');
    }

    public function url()
    {
        return $this->category->url()."?area=".$this->area;
    }
}
