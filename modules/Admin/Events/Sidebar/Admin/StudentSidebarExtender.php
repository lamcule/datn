<?php

namespace Modules\Admin\Events\Sidebar\Admin;


use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Admin\Sidebar\AbstractAdminSidebar;

class StudentSidebarExtender extends AbstractAdminSidebar
{

    /**
     * Method used to define your sidebar menu groups and items
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {

        $menu->group('student', function (Group $group) {
            $group->hideHeading(true);
            $group->item(trans('backend::sidebar.manage_student'), function (Item $item) {
                $item->icon('far fa-user-graduate');
                $item->weight(10);
                $item->route('admin.student.index');
                $item->authorize(
                    $this->auth->hasAccess('admin.student.index')
                );

                $item->item(trans('backend::sidebar.student'), function (Item $item) {

                    $item->weight(0);

                    $item->route('admin.student.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.student.index')
                    );
                });

                $item->item(trans('backend::sidebar.student_guest'), function (Item $item) {

                    $item->weight(1);

                    $item->route('admin.student_register.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.student.index')
                    );
                });



            });
        });

        return $menu;

    }
}
