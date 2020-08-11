<?php

namespace Modules\Admin\Events\Sidebar\Admin;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Admin\Sidebar\AbstractAdminSidebar;

class GradeSidebarExtender extends AbstractAdminSidebar
{
    /**
     * Method used to define your sidebar menu groups and items
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {

        $menu->group('grade', function (Group $group) {
            $group->hideHeading(true);
            $group->item(trans('backend::sidebar.grade'), function (Item $item) {
                $item->icon('fas fa-book');
                $item->weight(10);
                $item->route('admin.grade.index');
                $item->authorize(
                    $this->auth->hasAccess('admin.grade.index')
                );


            });
        });

        return $menu;

    }
}
