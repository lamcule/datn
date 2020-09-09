<?php

namespace Modules\Admin\Events\Sidebar\Admin;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Admin\Sidebar\AbstractAdminSidebar;

class ManageWebsiteSidebarExtender extends AbstractAdminSidebar
{
    /**
     * Method used to define your sidebar menu groups and items
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {

        $menu->group('manage website', function (Group $group) {
            $group->hideHeading(true);
            $group->item(trans('backend::sidebar.manage website'), function (Item $item) {
                $item->icon('far fa-lock');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('admin.banner.index')
                );
                $item->item(trans('backend::sidebar.banner'), function (Item $item) {

                    $item->weight(0);

                    $item->route('admin.banner.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.banner.index')
                    );
                });

            });
        });
        return $menu;

    }
}
