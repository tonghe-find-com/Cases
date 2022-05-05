<?php

namespace TypiCMS\Modules\Cases\Models;

use App\HasList;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Translatable\HasTranslations;
use TypiCMS\Modules\Core\Models\Base;
use TypiCMS\Modules\Files\Models\File;
use TypiCMS\Modules\Files\Traits\HasFiles;
use TypiCMS\Modules\History\Traits\Historable;
use TypiCMS\Modules\Cases\Presenters\ModulePresenter;

class Casecategory extends Base
{
    use HasFiles;
    use HasTranslations;
    use Historable;
    use PresentableTrait;
    use HasList;

    protected $presenter = ModulePresenter::class;

    protected $guarded = [];

    public $translatable = [
        'title',
        'slug',
        'status',
        'body',
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

    public function url()
    {
        return route(app()->getLocale()."::case",$this->slug);
    }

    public function allForSelect(): array
    {
        $categories = $this->order()
            ->get()
            ->pluck('title', 'id')
            ->all();

        return ['' => ''] + $categories;
    }

    public static function area(): array
    {

        return [
                '' => '',
                'newtaipei' => '新北市',
                'taipei' => '台北市',
                'keelung' => '基隆市',
                'taoyuan' => '桃園市',
                'miaoli' => '苗栗市',
                'hsinchucounty' => '新竹縣',
                'hsinchucity' => '新竹市',
                'taichung' => '台中市',
                'changhua' => '彰化市',
                'yunlin' => '雲林縣',
                'chiayicounty' => '嘉義縣',
                'chiayicity' => '嘉義市',
                'tinan' => '台南市',
                'kaohsiung' => '高雄市',
                'pingtung' => '屏東縣',
                'taitung' => '台東縣',
                'hualien' => '花蓮縣',
                'yilan' => '宜蘭縣',
                'nantou' => '南投縣',
                'punghu' => '澎湖縣',
                'kinmen' => '金門縣',
                'mazu' => '馬祖',
        ];
    }

    public static function getAreaName($area)
    {
        $list = self::area();
        return $list[$area] ?? '';
    }


    public static function getAreaList($list = [])
    {
        if(count($list) == 0){
            $list = Caseitem::all();
        }
        $area_list = [];
        foreach($list as $item){
            if(!in_array($item->area,$area_list)){
                array_push($area_list,$item->area);
            }
        }
        return $area_list;
    }

    public static function getAreaItem($area)
    {
        $list = Caseitem::published()->where('area',$area)->orderBy('position','ASC')->get();

        return $list;
    }
}
