<?php

namespace Modules\Admin\Events\Sidebar\Admin;


use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Admin\Sidebar\AbstractAdminSidebar;

class ReportSidebarExtender extends AbstractAdminSidebar
{

    /**
     * Method used to define your sidebar menu groups and items
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {

        $menu->group('report', function (Group $group) {
            $group->hideHeading(true);
            $group->item(trans('backend::sidebar.report'), function (Item $item) {
                $item->icon('far fa-tasks');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('admin.report.student')
                );
                $item->item(trans('backend::sidebar.report student'), function (Item $item) {

                    $item->weight(0);

                    $item->route('admin.report.student');
                    $item->authorize(
                        $this->auth->hasAccess('admin.report.student')
                    );
                });

                $item->item(trans('backend::sidebar.report grades'), function (Item $item) {

                    $item->weight(0);

                    $item->route('admin.report.grades');
                    $item->authorize(
                        $this->auth->hasAccess('admin.report.grades')
                    );
                });
                $item->item(trans('backend::sidebar.report studyent activity'), function (Item $item) {

                    $item->weight(0);

                    $item->route('admin.report.studentActivity');
                    $item->authorize(
                        $this->auth->hasAccess('admin.report.studentActivity')
                    );
                });
                $item->item(trans('backend::sidebar.report review history'), function (Item $item) {

                    $item->weight(0);

                    $item->route('admin.report.reviewHistory');
                    $item->authorize(
                        $this->auth->hasAccess('admin.report.reviewHistory')
                    );
                });
	            $item->item(trans('backend::sidebar.report student lesson'), function (Item $item) {

		            $item->weight(0);

		            $item->route('admin.report.studentLesson');
		            $item->authorize(
			            $this->auth->hasAccess('admin.report.studentLesson')
		            );
	            });

	            $item->item(trans('backend::sidebar.report course activity'), function (Item $item) {

		            $item->weight(0);

		            $item->route('admin.report.courseActivity');
		            $item->authorize(
			            $this->auth->hasAccess('admin.report.courseActivity')
		            );
	            });

            });
        });

        return $menu;

    }
}
