<?php

namespace Modules\Admin\Events\Sidebar\Admin;


use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Admin\Sidebar\AbstractAdminSidebar;

class StudentImportSidebarExtender extends AbstractAdminSidebar
{

    /**
     * Method used to define your sidebar menu groups and items
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {

        $menu->group('studentimport', function (Group $group) {
            $group->hideHeading(true);
            $group->item(trans('backend::sidebar.studentimport'), function (Item $item) {
                $item->icon('far fa-upload');
                $item->weight(10);
                $item->route('admin.studentimport.index');
                $item->authorize(
                    $this->auth->hasAccess('admin.studentimport.index')
                );




            });
        });

        return $menu;

    }
}
