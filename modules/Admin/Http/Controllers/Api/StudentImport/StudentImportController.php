<?php

namespace Modules\Admin\Http\Controllers\Api\StudentImport;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Admin\Entities\MultipleStudentImport;
use Modules\Admin\Repositories\ImportDetailRepository;
use Modules\Admin\Repositories\StudentRepository;
use Modules\Admin\Transformers\StudentImport\StudentImportTransformer;
use Modules\Guest\Events\StudentRegistedCourse;
use Modules\Guest\Repositories\GuestRepository;
use Modules\Mon\Entities\District;
use Modules\Mon\Entities\Grade;
use Modules\Mon\Entities\ImportDetail;
use Modules\Mon\Entities\Phoenix;
use Modules\Mon\Entities\Profile;
use Modules\Mon\Entities\Province;
use Modules\Mon\Entities\StudentImport;
use Modules\Admin\Http\Requests\StudentImport\CreateStudentImportRequest;
use Modules\Admin\Http\Requests\StudentImport\UpdateStudentImportRequest;
use Modules\Admin\Repositories\StudentImportRepository;
use Illuminate\Routing\Controller;
use Modules\Mon\Entities\User;
use Modules\Mon\Http\Controllers\ApiController;
use Modules\Mon\Auth\Contracts\Authentication;

class StudentImportController extends ApiController
{
    /**
     * @var StudentImportRepository
     */
    private $studentimportRepository;

    /**
     * @var StudentRepository
     */
    private $studentRepository;

    /**
     * @var GuestRepository
     */
    private $guestRepository;

    /**
     * @var ImportDetailRepository
     */
    private $importDetailRepository;

    public function __construct(
        Authentication $auth,
        StudentImportRepository $studentimport,
        StudentRepository $studentRepository,
        GuestRepository $guestRepository,
        ImportDetailRepository $importDetailRepository
    ) {
        parent::__construct($auth);

        $this->studentimportRepository = $studentimport;

        $this->studentRepository = $studentRepository;
        $this->guestRepository = $guestRepository;

        $this->importDetailRepository = $importDetailRepository;
    }


    public function index(Request $request)
    {
        return StudentImportTransformer::collection($this->studentimportRepository->serverPagingFor($request));
    }


    public function all(Request $request)
    {
        return StudentImportTransformer::collection($this->studentimportRepository->newQueryBuilder()->get());
    }


    public function store(CreateStudentImportRequest $request)
    {
        if ($request->hasFile('file')) {
            list($filename) = explode('.', $request->file->getClientOriginalName());


            $filename = $filename . '_' . time() . '_.' . $request->file->getClientOriginalExtension();
            $path =  $request->file('file')->storeAs('imports', $filename,  ['disk' => 'public']);
            $data = [
                'path' => $filename,
                'status' => StudentImport::STATUS_UPLOADED
            ];
            $studentImport = $this->studentimportRepository->create($data);

            $numberRecords = 0;
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load(storage_path('app/public/imports/' . $filename));
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            foreach ($sheetData as $row) {
                Log::info($row[1]);
                if ((isset($row[0]) && $row[0] == 'STT')|| empty($row[0]) ||  empty($row[1])) {
                    continue;
                }

                $importDetailData = [
                    'import_id' => $studentImport->id,
                    'content' => $row,
                    'status' => ImportDetail::STATUS_UPLOADED,
                ];
                $this->importDetailRepository->create($importDetailData);
                $numberRecords++;
            }
            $studentImport->records = $numberRecords;
            $studentImport->save();

            return response()->json([
                'errors' => false,
                'import_id' => $studentImport->id,
            ]);
        }
    }


    public function find(StudentImport $studentimport)
    {
        return new  StudentImportTransformer($studentimport);
    }

    public function update(
        StudentImport $studentimport,
        UpdateStudentImportRequest $request
    ) {
        $this->studentimportRepository->update($studentimport, $request->all());

        return response()->json([
            'errors' => false,
            'message' => trans('backend::studentimport.message.update success'),
        ]);
    }

    public function destroy(
        StudentImport $studentimport
    ) {
        $this->studentimportRepository->destroy($studentimport);

        return response()->json([
            'errors' => false,
            'message' => trans('backend::studentimport.message.delete success'),
        ]);
    }

    public function import(Request $request, StudentImport $studentimport)
    {


            DB::beginTransaction();
            try {

                //list area
                /** @var Collection $provinceIds */
                $provinceIds = Province::query()->get()->pluck('id', 'name');

                /** @var Collection $districtIds */
                $districtIds = District::query()->get()->pluck('id', 'name');

                /** @var Collection $phoenixIds */
                $phoenixIds = Phoenix::query()->get()->pluck('id', 'name');


                $studentimport->details()->chunk(100, function ($chunk) use ($phoenixIds, $districtIds, $provinceIds, $studentimport) {
                    foreach ($chunk as $importdetail) {
                        $student = null;
                        $row = $importdetail->content;

                        if (isset($row[0]) && $row[0] == 'STT' || empty($row[0])) {
                            continue;
                        }
                        $lastName = isset($row[1]) ? $row[1] : '';

                        $firstName = isset($row[2]) ? $row[2] : '';


                        $gender = isset($row[3]) ? $row[3] : '';
                        $bod = isset($row[4]) ? $row[4] : '';
                        $email = isset($row[5]) ? $row[5] : '';
                        $phone =  isset($row[6]) ? $row[6] : '';
                        $company = isset($row[7]) ? $row[7] : '';
                        $position =  isset($row[8]) ? $row[8] : '';
                        $company_address = isset($row[9]) ? $row[9] : '';

                        $address = isset($row[10]) ? $row[10] : '';
                        $phoenix = isset($row[11]) ? $row[11] : '';
                        $district = isset($row[12]) ? $row[12] : '';
                        $province =  isset($row[13]) ? $row[13] : '';



                        $registered_at = isset($row[14]) ? (string)$row[14] : '';

                        $categories = isset($row[15]) ? $row[15] : '';
                        $personal_categories =  isset($row[16]) ? $row[16] : '';
                        $source_contact = isset($row[17]) ? $row[17] : '';
                        $grade_codes = isset($row[18]) ? $row[18] : '';

                        $province_id = null;
                        $district_id = null;
                        $phoenix_id = null;

                        try {
                            $registered_at = Carbon::createFromFormat('d/m/Y', $registered_at)->format('Y-m-d 00:00:00');
                        }catch (\Exception $exception) {
                            $registered_at = null;
                        }

                        if ($provinceIds->has($province)) {
                            $province_id = $provinceIds->get($province);
                        }
                        if ($districtIds->has($district)) {
                            $district_id = $districtIds->get($district);
                        }
                        if ($phoenixIds->has($phoenix)) {
                            $phoenix_id = $phoenixIds->get($phoenix);
                        }

                        $userData = [

                            "first_name" => $firstName,

                            "last_name" => $lastName,
                            "gender" => $gender,
                            "birth_date" => $bod ? Carbon::createFromFormat('d/m/Y', $bod)->format('Y-m-d') : null,
                            "address" => $address,
                            "company" => $company,
                            "company_address" => $company_address,
                            "categories" => [$categories],
                            "personal_categories" => [$personal_categories],
                            "email" => $email,
                            "phone" => $phone,

                            "roles" => [],
                            "is_new" => true,
                            "status" => "active",
                            "type" => "student",
                            "province_id" => $province_id,
                            "district_id" => $district_id,
                            "phoenix_id" => $phoenix_id,
                            "position" => $position,
                            'source' => $source_contact

                        ];
                        if (!empty($email)) {
                            $student = User::query()->where('email', $email)->first();
                        }

                        if (!$student && !empty($phone)) {
                            $profile = Profile::query()->where('phone', $phone)->with('user')->first();
                            $student = null;
                            if ($profile) {
                                $student = $profile->user;
                            }
                        }



                        if (!$student) {
                            $student = $this->studentRepository->create($userData);
                        } else {
                            $student = $this->studentRepository->update($student, $userData);
                        }
                        $gradesCode = explode(',', $grade_codes);
                        $message='';
                        $status = true;
                        if (!empty($grade_codes)) {
                            foreach ($gradesCode as $gradeCode) {
                                /** @var Grade $grade */
                                $grade = Grade::query()->where('code', trim($gradeCode))->first();
                                if (!$grade) {
                                    $message .= "Lớp học $gradeCode không tồn tại. ";
                                    $status = false;
                                } else {
                                    // regist grade
                                    $result = $this->guestRepository->registGrade($student, $grade, $registered_at);
                                    if ($result === true) {
                                        event(new StudentRegistedCourse($student, $grade));
                                        $message = "";
                                        $status = true;

                                    } else {
                                        $message .= "Học viên đã đăng ký khoá học $gradeCode ";
                                        $status = false;
                                    }
                                }
                            }
                        }




                        if ($status) {
                            $importdetail->status = ImportDetail::STATUS_IMPORTED;
                        } else {
                            $importdetail->status = ImportDetail::STATUS_ERROR;
                        }
                        $importdetail->imported_description = [$message];
                        $importdetail->save();
                    }
                });

                $studentimport->status = StudentImport::STATUS_IMPORTED;
                $studentimport->save();
                DB::commit();
            }catch (\Exception $exception) {
                Log::info($exception->getMessage());
                DB::rollBack();
                return response()->json([
                    'errors' => false,
                    'status' => StudentImport::STATUS_IMPORTED,
                    'message' => $exception->getMessage(),
                ]);
            }

            return response()->json([
                'errors' => false,
                'status' => StudentImport::STATUS_IMPORTED,
                'message' => 'Import thành công',
            ]);

    }
}
