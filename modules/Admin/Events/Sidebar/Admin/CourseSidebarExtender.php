<?php

namespace Modules\Admin\Events\Sidebar\Admin;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Admin\Sidebar\AbstractAdminSidebar;

class CourseSidebarExtender extends AbstractAdminSidebar
{
    /**
     * Method used to define your sidebar menu groups and items
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {

        $menu->group('course', function (Group $group) {
            $group->hideHeading(true);
            $group->item(trans('backend::sidebar.course'), function (Item $item) {
                $item->icon('fas fa-book');
                $item->weight(10);
                $item->route('admin.course.index');
                $item->authorize(
                    $this->auth->hasAccess('admin.course.index')
                );


            });
        });
        $menu->group('qrcode', function (Group $group) {
            $group->hideHeading(true);
            $group->item(trans('backend::sidebar.qrcode'), function (Item $item) {
                $item->icon('far fa-qrcode');
                $item->weight(10);
                $item->route('admin.lesson.qrcode');
                $item->authorize(
                    $this->auth->hasAccess('admin.lesson.qrcode')
                );




            });
        });
        $menu->group('checkinout', function (Group $group) {
            $group->hideHeading(true);
            $group->item(trans('backend::sidebar.checkinout'), function (Item $item) {
                $item->icon('far fa-recycle');
                $item->weight(10);
                $item->route('admin.checkinout.index');
                $item->authorize(
                    $this->auth->hasAccess('admin.checkinout.index')
                );




            });
        });
        return $menu;

    }
}
