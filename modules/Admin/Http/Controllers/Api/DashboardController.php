<?php

namespace Modules\Admin\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Entities\DistrictImport;
use Modules\Admin\Entities\ProvinceImport;
use Modules\Admin\Repositories\ProvinceRepository;
use Modules\Admin\Repositories\StudentRepository;
use Modules\Admin\Transformers\District\DistrictTransformer;
use Modules\Mon\Entities\Course;
use Modules\Mon\Entities\District;
use Modules\Admin\Http\Requests\District\CreateDistrictRequest;
use Modules\Admin\Http\Requests\District\UpdateDistrictRequest;
use Modules\Admin\Repositories\DistrictRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\Province;
use Modules\Mon\Entities\User;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class DashboardController extends ApiController
{
    public $listColors = [
        '#f56954',
        '#39CCCC',
        '#605ca8',
        '#C16E5D',
        '#CC3D1F',
        '#31CC1F',
        '#1F1FCC',
        '#B41FCC',
        '#CC1F7B',
        '#CD5C5C',
        '#ff851b',
        '#00c0ef',
        '#3c8dbc',

    ];
    public function index(Request $request)
    {
        $total_student = User::query()->where('type', User::TYPE_STUDENT)->count();
        $total_course = Course::query()->count();
        $total_grade = Grade::query()->count();
        $total_address = Grade::query()->select('province_id')->distinct()->count();

        return response()->json([
            'board' => [
                'total_student' => $total_student,
                'total_course' => $total_course,
                'total_grade' => $total_grade,
                'total_address' => $total_address,
            ]
        ]);
    }
    public function chart1(Request $request) {
        $res= User::query()->where('type',User::TYPE_STUDENT)
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($val) {
                return Carbon::parse($val->created_at)->format('m-Y');
            });
         $data =[];
         $labels = [];
         foreach ($res as $month => $students) {
             $labels[] = $month;
             $data[] = count($students);
         }
        $datasets[] = [
            'label' => 'Biểu đồ đường lượng học viên theo thời gian',
            'backgroundColor' =>  '#2FC25B',
            'data'=> $data
        ];
         return [
             'labels' => $labels,
             'datasets' => $datasets
         ];
    }
    public function chart2(Request $request) {
        $res= User::query()->where('type',User::TYPE_STUDENT)
            ->with(['profile' ])
            ->orderBy('created_at')
            ->get()
            ->groupBy('profile.province_id');
        $data =[];
        $labels = [];
        foreach ($res as $id => $students) {
            $province = Province::query()->where('id', $id)->first();
            $labels[] = $province? $province->name: 'Khác';
            $data[] = count($students);
        }
        $datasets[] = [
            'label' => 'Biểu đồ lượng học viên theo khu vực',
            'backgroundColor' => $this->listColors,
            'data'=> $data
        ];
        return [
            'labels' => $labels,
            'datasets' => $datasets
        ];
    }
    public function chart3(Request $request) {
        $res= Grade::query()
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($val) {
                return Carbon::parse($val->created_at)->format('m-Y');
            });
        $data =[];
        $labels = [];
        foreach ($res as $month => $grades) {
            $labels[] = $month;
            $data[] = count($grades);
        }
        $datasets[] = [
            'label' => 'Biểu đồ lớp học theo thời gian',
            'backgroundColor' =>  '#31CC1F',
            'data'=> $data,
            'borderColor' => "#00c0ef",

            'fill' => false,
            'borderWidth'=> 2,
        ];
        return [
            'labels' => $labels,
            'datasets' => $datasets
        ];
    }
    public function chart4(Request $request) {
        $res= Grade::query()
            ->orderBy('created_at')
            ->get()
            ->groupBy('province_id');
        $data =[];
        $labels = [];
        foreach ($res as $id => $grades) {
            $province = Province::query()->where('id', $id)->first();
            $labels[] = $province? $province->name: 'Khác';
            $data[] = count($grades);
        }
        $datasets[] = [
            'label' => 'Biểu đồ lượng lớp theo khu vực',
            'backgroundColor' => $this->listColors,
            'data'=> $data
        ];
        return [
            'labels' => $labels,
            'datasets' => $datasets
        ];
    }
    public function test()
    {

        $collection = Excel::toCollection(new DistrictImport(), base_path('modules/Admin/Console/data/phoenix.xlsx'),
            null, \Maatwebsite\Excel\Excel::XLSX);
        $phoenixes = $collection->first();
        return $phoenixes;
    }


}
