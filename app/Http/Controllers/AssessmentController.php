<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Period;
use App\Models\Subject;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Str;


class AssessmentController extends Controller
{

    public function detailView(Request $request, string $id)
    {

        $me = $request->attributes->get("me");


        $assessment = Assessment::query()->where("id", $id)->first();
        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "ASSESSMENT",
            "subMenuItemActive" => "ASSESSMENT",
            "assessmentDetail" => [
                "data" => [
                    "id" => $assessment->id,
                    "start_at" => $assessment->start_at,
                    "end_at" => $assessment->end_at,
                    "subject" => $assessment->subject,
                    "classroom" => $assessment->classroom,
                    "period" => $assessment->period,
                ]
            ]
        ];
        return view("dashboard", $data);
    }
    public function listView(Request $request)
    {

        $search = $request->input("search");
        $limit = 10;
        $pageNumber = $request->input("pageNumber", 1);
        $offset = ($pageNumber - 1) * $limit;

        $classroom = $request->input("classroom");
        $period = $request->input("period");
        $subject = $request->input("subject");

        $assessments = Assessment::query();
        if ($classroom) {
            $assessments->where("classroom", $classroom);
        }
        if ($period) {
            $assessments->where("period", $period);
        }
        if ($subject) {
            $assessments->where("subject", $subject);
        }

        if ($search) {
            $assessments->whereRaw("
            lower(
                concat(
                    coalesce(name, ''),
                    coalesce(subject, ''),
                    coalesce(classroom, ''),
                    coalesce(period, '')
                )
            )
            like lower(?)", ["%" . $search . "%"]);
        }

        $total = $assessments->count();
        $numberOfPages = ceil($total / $limit);
        $pageNumber = ceil($offset / $limit) + 1;


        $assessments = $assessments
            ->orderBy("updated_at", "desc")
            ->offset($offset)
            ->limit($limit)
            ->get();

        $contents = $assessments->map(function ($assessment) {
            return [
                "id" => $assessment->id,
                "name" => $assessment->name,
                "start_at" => $assessment->start_at,
                "end_at" => $assessment->end_at,
                "subject" => $assessment->subject,
                "classroom" => $assessment->classroom,
                "period" => $assessment->period,
            ];
        });
        $me = $request->attributes->get("me");

        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "ASSESSMENT",
            "subMenuItemActive" => "ASSESSMENT",
            "numberOfPages" => $numberOfPages,
            "pageNumber" => $pageNumber,
            "classrooms" => Classroom::all()->map(function ($p) {
                return $p->id;
            }),
            "periods" => Period::all()->map(function ($p) {
                return $p->id;
            }),
            "subjects" => Subject::all()->map(function ($p) {
                return $p->id;
            }),
            "assessmentList" => [
                "name" => "assessment",
                "title" => "Assessment",
                "columns" => ["nama", "mulai", "selesai", "mata pelajaran", "kelas", "tahun ajaran"],
                "contents" => $contents,
            ]
        ];
        return view("dashboard", $data);
    }

    public function createView(Request $request)
    {
        $me = $request->attributes->get("me");

        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "ASSESSMENT",
            "subMenuItemActive" => "ASSESSMENT",
            "assessmentCreate" => true,
            "periods" => Period::all()->map(function ($p) {
                return $p->id;
            }),
            "classrooms" => Classroom::all()->map(function ($p) {
                return $p->id;
            }),
            "subjects" => Subject::all()->map(function ($p) {
                return $p->id;
            }),
        ];
        return view("dashboard", $data);
    }
    public function editView(Request $request, string $id)
    {
        $me = $request->attributes->get("me");

        $assessment = Assessment::query()->where("id", $id)->first();
        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "ASSESSMENT",
            "subMenuItemActive" => "ASSESSMENT",
            "periods" => Period::all()->map(function ($p) {
                return $p->id;
            }),
            "classrooms" => Classroom::all()->map(function ($p) {
                return $p->id;
            }),
            "subjects" => Subject::all()->map(function ($p) {
                return $p->id;
            }),
            "assessmentUpdate" => [
                "id" => $assessment->id,
                "name" => $assessment->name,
                "start_at" => $assessment->start_at,
                "end_at" => $assessment->end_at,
                "subject" => $assessment->subject,
                "classroom" => $assessment->classroom,
                "period" => $assessment->period,
            ]
        ];
        return view("dashboard", $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'subject' => 'required',
            'classroom' => 'required',
            'period' => 'required',
        ]);

        $id = Str::uuid();
        $name = $request->input("name");
        $start_at = $request->input("start_at");
        $end_at = $request->input("end_at");
        $subject = $request->input("subject");
        $classroom = $request->input("classroom");
        $period = $request->input("period");

        $assessment = Assessment::query()->find($id);
        if ($assessment != null) {
            throw new HttpException(409, "CONFLICT");
        }

        Assessment::create([
            "id" => $id,
            "name" => $name,
            "start_at" => $start_at,
            "end_at" => $end_at,
            "subject" => $subject,
            "classroom" => $classroom,
            "period" => $period,
        ]);

        return redirect("/web/dashboard/assessment");
    }
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'name' => 'required',
        ]);
        
        $assessment = Assessment::query()->where("id", $id)->first();
        if ($assessment == null) {
            throw new HttpException(404, "NOT_FOUND");
        }
        $assessment->name = $request->input("name");
        $assessment->start_at = $request->input("start_at");
        $assessment->end_at = $request->input("end_at");
        $assessment->subject = $request->input("subject");
        $assessment->classroom = $request->input("classroom");
        $assessment->period = $request->input("period");
        $assessment->save();

        return redirect("/web/dashboard/assessment/" . $id . "/edit");
    }

    public function delete(Request $request, string $id)
    {
        $assessment = Assessment::query()->where("id", $id)->first();
        if ($assessment == null) {
            throw new HttpException(404, "NOT_FOUND");
        }
        $assessment->delete();

        return redirect("/web/dashboard/assessment/");
    }
}
