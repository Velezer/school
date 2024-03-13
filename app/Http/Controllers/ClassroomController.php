<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function listView(Request $request)
    {
        $me = $request->attributes->get("me");
        $classrooms = Classroom::all();

        $contents = $classrooms->map(function ($c) {
            return [
                "id" => $c->id,
            ];
        });

        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "CLASSROOM",
            "subMenuItemActive" => "CLASSROOM",
            "classroomList" => [
                "columns" => ["id", "nama"],
                "title" => "Classroom",
                "contents" => $contents,
            ]
        ];
        return view("dashboard", $data);
    }
}
