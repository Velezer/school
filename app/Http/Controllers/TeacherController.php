<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TeacherController extends Controller
{

    public function listView(Request $request)
    {

        $user = $request->attributes->get("me");


        $search = $request->input("search");
        $limit = 10;
        $pageNumber = $request->input("pageNumber", 1);
        $offset = ($pageNumber - 1) * $limit;

        $users = User::where("role", "TEACHER");
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
                "address" => $user->address,
                // "gender" => $user->gender,
                // "religion" => $user->religion,
                // "dob" => $user->dob,
            ];
        });
        $data = [
            "me" => [
                "id" => $user->id,
                "name" => $user->name,
                "role" => $user->role
            ],
            "menuItemActive" => "USER",
            "subMenuItemActive" => "TEACHER",
            "numberOfPages" => $numberOfPages,
            "pageNumber" => $pageNumber,
            "teacherList" => [
                "name" => "teacher",
                "title" => "Teacher",
                "columns" => [
                    "NIP", "Nama", "Alamat"
                    // ,"gender","religion","dob"
                ],
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

        return redirect("/web/dashboard/teacher/");
    }
}
