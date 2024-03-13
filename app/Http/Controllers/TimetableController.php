<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Period;
use App\Models\Subject;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Str;


class TimetableController extends Controller
{

    public function listView(Request $request)
    {
        $me = $request->attributes->get("me");

        $search = $request->input("search");
        $limit = 10;
        $pageNumber = $request->input("pageNumber", 1);
        $offset = ($pageNumber - 1) * $limit;

        $classroom = $request->input("classroom");
        $period = $request->input("period");
        $subject = $request->input("subject");

        $timetables = Timetable::query();
        if ($classroom) {
            $timetables->where("classroom", $classroom);
        }
        if ($period) {
            $timetables->where("period", $period);
        }
        if ($subject) {
            $timetables->where("subject", $subject);
        }

        if ($search) {
            $timetables->whereRaw("
            lower(
                concat(
                    coalesce(day, ''),
                    coalesce(time, ''),
                    coalesce(subject, ''),
                    coalesce(classroom, ''),
                    coalesce(period, '')
                )
            )
            like lower(?)", ["%" . $search . "%"]);
        }

        $total = $timetables->count();
        $numberOfPages = ceil($total / $limit);
        $pageNumber = ceil($offset / $limit) + 1;


        $timetables = $timetables
            ->orderBy("updated_at", "desc")
            ->offset($offset)
            ->limit($limit)
            ->get();

        $contents = $timetables->map(function ($timetable) {
            return [
                "id" => $timetable->id,
                "day" => $timetable->day,
                "time" => $timetable->time,
                "subject" => $timetable->subject,
                "classroom" => $timetable->classroom,
                "period" => $timetable->period,
                "semester" => $timetable->semester,
            ];
        });
        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "TIMETABLE",
            "subMenuItemActive" => "TIMETABLE",
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
            "timetableList" => [
                "name" => "timetable",
                "title" => "Timetable",
                "columns" => ["hari", "waktu", "mata pelajaran", "kelas", "tahun ajaran", "semester"],
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
            "menuItemActive" => "TIMETABLE",
            "subMenuItemActive" => "TIMETABLE",
            "timetableCreate" => true,
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
        $timetable = Timetable::query()->where("id", $id)->first();
        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "TIMETABLE",
            "subMenuItemActive" => "TIMETABLE",
            "periods" => Period::all()->map(function ($p) {
                return $p->id;
            }),
            "classrooms" => Classroom::all()->map(function ($p) {
                return $p->id;
            }),
            "subjects" => Subject::all()->map(function ($p) {
                return $p->id;
            }),
            "timetableUpdate" => [
                "id" => $timetable->id,
                "day" => $timetable->day,
                "time" => $timetable->time,
                "subject" => $timetable->subject,
                "classroom" => $timetable->classroom,
                "period" => $timetable->period,
            ]
        ];
        return view("dashboard", $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'day' => 'required',
            'time' => 'required',
            'subject' => 'required',
            'classroom' => 'required',
            'period' => 'required',
            'semester' => 'required',
        ]);

        $id = Str::uuid();
        $day = $request->input("day");
        $time = $request->input("time");
        $subject = $request->input("subject");
        $classroom = $request->input("classroom");
        $period = $request->input("period");
        $semester = $request->input("semester");

        $timetable = Timetable::query()->find($id);
        if ($timetable != null) {
            throw new HttpException(409, "CONFLICT");
        }

        Timetable::create([
            "id" => $id,
            "day" => $day,
            "time" => $time,
            "subject" => $subject,
            "classroom" => $classroom,
            "period" => $period,
            "semester" => $semester,
        ]);

        return redirect("/web/dashboard/timetable");
    }
    
    public function update(Request $request, string $id)
    {
        $request->validate([
            'day' => 'required',
            'time' => 'required',
            'subject' => 'required',
            'classroom' => 'required',
            'period' => 'required',
            'semester' => 'required',
        ]);

        $timetable = Timetable::query()->where("id", $id)->first();
        if ($timetable == null) {
            throw new HttpException(404, "NOT_FOUND");
        }

        $timetable->day = $request->input("day");
        $timetable->time = $request->input("time");
        $timetable->subject = $request->input("subject");
        $timetable->classroom = $request->input("classroom");
        $timetable->period = $request->input("period");
        $timetable->semester = $request->input("semester");
        $timetable->save();

        return redirect("/web/dashboard/timetable/" . $id . "/edit");
    }

    public function delete(Request $request, string $id)
    {
        $timetable = Timetable::query()->where("id", $id)->first();
        if ($timetable == null) {
            throw new HttpException(404, "NOT_FOUND");
        }
        $timetable->delete();

        return redirect("/web/dashboard/timetable/");
    }
}
