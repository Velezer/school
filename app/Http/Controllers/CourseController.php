<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Period;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Str;


class CourseController extends Controller
{

    public function detailView(Request $request, string $id)
    {
        $me = $request->attributes->get("me");

        $course = Course::query()->where("id", $id)->first();

        $data = [
            "readonly" => true,
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "COURSE",
            "subMenuItemActive" => "COURSE",
            "courseDetail" => [
                "id" => $course->id,
                "name" => $course->name,
                "content" => $course->content,
                "subject" => $course->subject,
                "classroom" => $course->classroom,
                "period" => $course->period,
                "semester" => $course->semester,
                "youtube" => $course->youtube,
            ]
        ];
        return view("dashboard", $data);
    }
    public function listView(Request $request)
    {
        $me = $request->attributes->get("me");

        $search = $request->input("search");
        $limit = 10;
        $pageNumber = $request->input("pageNumber", 1);
        $offset = ($pageNumber - 1) * $limit;

        $name = $request->input("name");
        $classroom = $request->input("classroom");
        $period = $request->input("period");
        $subject = $request->input("subject");

        $courses = Course::query();
        if ($name) {
            $courses->where("name", $name);
        }
        if ($classroom) {
            $courses->where("classroom", $classroom);
        }
        if ($period) {
            $courses->where("period", $period);
        }
        if ($subject) {
            $courses->where("subject", $subject);
        }

        if ($search) {
            $courses->whereRaw("
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

        $total = $courses->count();
        $numberOfPages = ceil($total / $limit);
        $pageNumber = ceil($offset / $limit) + 1;


        $courses = $courses
            ->orderBy("updated_at", "desc")
            ->offset($offset)
            ->limit($limit)
            ->get();

        $contents = $courses->map(function ($course) {
            return [
                "id" => $course->id,
                "name" => $course->name,
                "content" => $course->content,
                "subject" => $course->subject,
                "classroom" => $course->classroom,
                "period" => $course->period,
                "semester" => $course->semester,
            ];
        });
        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "COURSE",
            "subMenuItemActive" => "COURSE",
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
            "courseList" => [
                "name" => "course",
                "title" => "Course",
                "columns" => ["nama", "konten", "mata pelajaran", "kelas", "tahun ajaran", 'semester'],
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
            "menuItemActive" => "COURSE",
            "subMenuItemActive" => "COURSE",
            "courseCreate" => true,
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

        $course = Course::query()->where("id", $id)->first();

        
        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "COURSE",
            "subMenuItemActive" => "COURSE",
            "periods" => Period::all()->map(function ($p) {
                return $p->id;
            }),
            "classrooms" => Classroom::all()->map(function ($p) {
                return $p->id;
            }),
            "subjects" => Subject::all()->map(function ($p) {
                return $p->id;
            }),
            "courseUpdate" => [
                "id" => $course->id,
                "name" => $course->name,
                "content" => $course->content,
                "subject" => $course->subject,
                "classroom" => $course->classroom,
                "period" => $course->period,
                "semester" => $course->semester,
                "youtube" => $course->youtube,
            ]
        ];
        return view("dashboard", $data);
    }

    public function create(Request $request)
    {

        $violations = $request->validate([
            'name' => 'required',
            'subject' => 'required',
            'classroom' => 'required',
            'period' => 'required',
            'semester' => 'required',
        ]);


        $path = "";
        if($request->file('content')){
            $path = $request->file('content')->store(
                'courses', 'public'
            );
        }

        $id = Str::uuid();
        $name = $request->input("name");
        $subject = $request->input("subject");
        $classroom = $request->input("classroom");
        $period = $request->input("period");
        $semester = $request->input("semester");
        $youtube = $request->input("youtube");

        $course = Course::query()->find($id);
        if ($course != null) {
            throw new HttpException(409, "CONFLICT");
        }

        Course::create([
            "id" => $id,
            "name" => $name,
            "content" => $path,
            "subject" => $subject,
            "classroom" => $classroom,
            "period" => $period,
            "semester" => $semester,
            "youtube" => $youtube,
        ]);

        return redirect("/web/dashboard/course");
    }
    public function update(Request $request, string $id)
    {
        $violations = $request->validate([
            'name' => 'required',
            'subject' => 'required',
            'classroom' => 'required',
            'period' => 'required',
            'semester' => 'required',
        ]);
        
        $path = "";
        if ($request->file('content')) {
            $path = $request->file('content')->store(
                'courses', 'public'
            );
        }

        
        $course = Course::query()->where("id", $id)->first();
        if ($course == null) {
            throw new HttpException(404, "NOT_FOUND");
        }
        $course->name = $request->input("name");
        if ($path) {
            $course->content = $path;
        }
        $course->subject = $request->input("subject");
        $course->classroom = $request->input("classroom");
        $course->period = $request->input("period");
        $course->semester = $request->input("semester");
        $course->youtube = $request->input("youtube");
        $course->save();

        return redirect("/web/dashboard/course/" . $id . "/edit");
    }

    public function delete(Request $request, string $id)
    {
        $course = Course::query()->where("id", $id)->first();
        if ($course == null) {
            throw new HttpException(404, "NOT_FOUND");
        }
        $course->delete();

        return redirect("/web/dashboard/course/");
    }
}
