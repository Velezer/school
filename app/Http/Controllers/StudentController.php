<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Enums\UserRole;
use App\Models\Period;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StudentController extends Controller
{

    public function detailView(Request $request, string $id)
    {

        $user = User::query()->where("id", $id)->first();
        $data = [
            "menuItemActive" => "USER",
            "subMenuItemActive" => "STUDENT",
            "studentDetail" => [
                "data" => [
                    "id" => $user->id,
                    "name" => $user->name,
                    "address" => $user->address,
                    "classroom" => $user->classroom,
                    "gender" => $user->gender,
                    "religion" => $user->religion,
                    "dob" => $user->dob,
                    "period" => $user->period,
                ]
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

        $classroom = $request->input("classroom");
        $period = $request->input("period");

        if ($me->role == 'STUDENT') {
            $classroom = $me->classroom;
        }

        $users = User::where("role", "STUDENT");
        if ($classroom) {
            $users->where("classroom", $classroom);
        }
        if ($period) {
            $users->where("period", $period);
        }

        if ($search) {
            $users->whereRaw("
            lower(
                concat(
                    coalesce(id, ''),
                    coalesce(name, '')
                )
            )
            like lower(?)", ["%" . $search . "%"]);
        }

        $total = $users->count();
        $numberOfPages = ceil($total / $limit);
        $pageNumber = ceil($offset / $limit) + 1;


        $users = $users
            ->orderBy("updated_at", "desc")
            ->offset($offset)
            ->limit($limit)
            ->get();

        $contents = $users->map(function ($user) {
            return [
                "id" => $user->id,
                "name" => $user->name,
                "classroom" => $user->classroom,
                "period" => $user->period,
            ];
        });

        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "USER",
            "subMenuItemActive" => "STUDENT",
            "numberOfPages" => $numberOfPages,
            "pageNumber" => $pageNumber,
            "classrooms" => Classroom::all()->map(function ($p) {
                return $p->id;
            }),
            "periods" => Period::all()->map(function ($p) {
                return $p->id;
            }),
            "studentList" => [
                "name" => "student",
                "title" => "Student",
                "columns" => ["id", "nama", "kelas", "tahun ajaran"],
                "contents" => $contents,
            ]
        ];
        return view("dashboard", $data);
    }

    public function delete(Request $request, string $id)
    {
        $user = User::query()->where("id", $id)->first();
        if ($user == null) {
            throw new HttpException(403, "FORBIDDEN");
        }
        $user->delete();

        return redirect("/web/dashboard/student/");
    }
}
