<?php

namespace Modules\Admin\Events\Sidebar\Admin;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Admin\Sidebar\AbstractAdminSidebar;

class TeacherSidebarExtender extends AbstractAdminSidebar
{
    /**
     * Method used to define your sidebar menu groups and items
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {

        $menu->group('teacher', function (Group $group) {
            $group->hideHeading(true);
            $group->item(trans('backend::sidebar.teacher'), function (Item $item) {
                $item->icon('fas fa-book');
                $item->weight(10);
                $item->route('admin.teacher.index');
                $item->authorize(
                    $this->auth->hasAccess('admin.teacher.index')
                );


            });
        });

        return $menu;

    }
}
