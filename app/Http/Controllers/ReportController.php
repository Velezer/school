<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Classroom;
use App\Models\Grade;
use App\Models\Period;
use App\Models\Report;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Str;


class ReportController extends Controller
{

    public function detailView(Request $request, string $id)
    {

        $me = $request->attributes->get("me");
        $report = Report::query()->where("id", $id)->first();

        $contents = Grade::query()->where("report_id", $report->id)->get()
            ->map(function (Grade $grade) {
                return [
                    "subject" => $grade->subject,
                    "grade" => $grade->grade,
                    "kkm" => $grade->kkm,
                    "classRate" => $grade->class_rate,
                ];
            });

        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "REPORT",
            "subMenuItemActive" => "REPORT",
            "reportDetail" => [
                "name" => $report->user->name,
                "classroom" => $report->classroom,
                "semester" => $report->semester,
                "period" => $report->period,
                "columns" => [
                    "Mata Pelajaran",
                    "KKM",
                    "Nilai (Angka)",
                    "Rata-Rata Kelas",
                ],
                "contents" => $contents
            ]
        ];
        return view("dashboard", $data);
    }

    public function listView(Request $request)
    {

        $me = $request->attributes->get("me");
        $limit = 10;
        $pageNumber = $request->input("pageNumber", 1);
        $offset = ($pageNumber - 1) * $limit;

        $reports = Report::query();

        $search = $request->input("search");
        if ($search) {
            $reports
                ->select(
                    "reports.*"
                )
                ->join('users', 'reports.user_id', '=', 'users.id')
                ->whereRaw("
                    lower(
                        concat(
                            coalesce(users.name, '')
                        )
                    )
                    like lower(?)", ["%" . $search . "%"]);
        }

        $total = $reports->count();
        $numberOfPages = ceil($total / $limit);
        $pageNumber = ceil($offset / $limit) + 1;


        $reports = $reports
            ->orderBy("reports.updated_at", "desc")
            ->offset($offset)
            ->limit($limit)
            ->get();


        $contents = $reports->map(function (Report $report) {
            return [
                "id" => $report->id,
                "userName" => $report->user->name,
                "classroom" => $report->classroom,
                "period" => $report->period,
                "semester" => $report->semester,
            ];
        });

        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "REPORT",
            "subMenuItemActive" => "REPORT",
            "numberOfPages" => $numberOfPages,
            "pageNumber" => $pageNumber,
            "reportList" => [
                "name" => "report",
                "title" => "Report",
                "columns" => ["siswa", "kelas", "tahun ajaran", "semester"],
                "contents" => $contents
            ]
        ];
        return view("dashboard", $data);
    }

    public function createView(Request $request)
    {

        $me = $request->attributes->get("me");
        $students = User::query()->where("role", "STUDENT")->get();
        $students = $students->map(function (User $u) {
            return [
                "id" => $u->id,
                "name" => $u->name,
            ];
        });


        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "REPORT",
            "subMenuItemActive" => "REPORT",
            "classrooms" => Classroom::all()->map(function ($p) {
                return $p->id;
            }),
            "periods" => Period::all()->map(function ($p) {
                return $p->id;
            }),
            "subjects" => Subject::all()->map(function ($p) {
                return $p->id;
            }),
            "reportCreate" => true,
            "students" => $students
        ];
        return view("dashboard", $data);
    }

    public function editView(Request $request, string $id)
    {

        $me = $request->attributes->get("me");
        $report = Report::query()->find($id);

        $timetables = Timetable::query()
            ->where("classroom", $report->classroom)
            ->where("period", $report->period)
            ->where("semester", $report->semester)
            ->get();


        $subjects = $timetables
            ->map(function (Timetable $t) {
                return $t->subject;
            });

        $grades = Grade::query()
            ->where("report_id", $report->id)
            ->get()
            ->mapWithKeys(function (Grade $grade) {
                return [
                    $grade->subject => $grade
                ];
            });

        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "REPORT",
            "subMenuItemActive" => "REPORT",
            "subjects" => $subjects,
            "reportUpdate" => [
                "id" => $id,
                "grades" => $grades,
            ],
            "selected" => [
                "studentName" => $report->user->name,
                "classroom" => $report->classroom,
                "period" => $report->period,
                "semester" => $report->semester,
            ],
        ];
        return view("dashboard", $data);
    }


    public function create(Request $request)
    {

        $request->validate([
            "student_id" => "required",
            "classroom" => "required",
            "period" => "required",
            "semester" => "required",
        ]);

        $user = User::query()->find($request->input("student_id"));


        $id = Str::uuid();

        Report::create([
            "id" => $id,
            "period" => $request->input("period"),
            "classroom" => $request->input("classroom"),
            "semester" => $request->input("semester"),
            "user_id" => $user->id,
        ]);

        return redirect(route("webReportUpdate", $id));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            "grades" => "required",
        ]);

        $report = Report::query()->find($id);


        $grades = $request->input("grades");

        $willBeCreated = collect($grades)->map(function ($grade, $subject) use ($report) {
            return [
                "id" => Str::uuid(),
                "report_id" => $report->id,
                "grade" => $grade['grade'],
                "kkm" => $grade['kkm'],
                "class_rate" => $grade['classRate'],
                "subject" => $subject
            ];
        })->values()->all();

        Grade::query()->where("report_id", $report->id)->delete();
        Grade::insert($willBeCreated);

        return redirect(route("webReportUpdate", $id));
    }



    public function delete(Request $request, string $id)
    {
        $report = Report::query()->where("id", $id)->first();
        if ($report == null) {
            throw new HttpException(404, "NOT_FOUND");
        }
        $report->delete();

        return redirect("/web/dashboard/report/");
    }
}
