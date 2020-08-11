<?php

namespace Modules\Admin\Events\Sidebar\Admin;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Admin\Sidebar\AbstractAdminSidebar;

class ReviewSidebarExtender extends AbstractAdminSidebar
{
    /**
     * Method used to define your sidebar menu groups and items
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
//        $menu->group('review', function (Group $group) {
//            $group->hideHeading(true);
//            $group->item(trans('backend::sidebar.review'), function (Item $item) {
//                $item->icon('fas fa-file-pdf');
//                $item->weight(10);
//                $item->route('admin.userreview.index');
//                $item->authorize(
//                    $this->auth->hasAccess('admin.userreview.index')
//                );
//
//
//            });
//        });
        return $menu;
    }
}
