<?php

namespace TypiCMS\Modules\Cases\Composers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Sidebar\SidebarGroup;
use Maatwebsite\Sidebar\SidebarItem;

class SidebarViewComposer
{
    public function compose(View $view)
    {
        if (!Gate::denies('read casecategories')) {
            $view->sidebar->group(__('Case Group'), function (SidebarGroup $group) {
                $group->id = 'casegroup';
                $group->weight = 32;
                $group->addItem(__('Casecategories'), function (SidebarItem $item) {
                    $item->id = 'casecategories';
                    $item->icon = config('typicms.casecategories.sidebar.icon');
                    $item->weight = 1;
                    $item->route('admin::index-casecategories');
                    $item->append('admin::create-casecategory');
                });
            });
        }

        if (!Gate::denies('read cases')) {
            $view->sidebar->group(__('Case Group'), function (SidebarGroup $group) {
                $group->id = 'casegroup';
                $group->weight = 32;
                $group->addItem(__('Cases'), function (SidebarItem $item) {
                    $item->id = 'cases';
                    $item->icon = config('typicms.cases.sidebar.icon');
                    $item->weight = 2;
                    $item->route('admin::index-cases');
                    $item->append('admin::create-case');
                });
            });
        }

        return;
    }
}
