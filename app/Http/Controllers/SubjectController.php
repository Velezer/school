<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SubjectController extends Controller
{

    public function listView(Request $request)
    {
        $me = $request->attributes->get("me");

        $search = $request->input("search");

        $limit = 10;
        $pageNumber = $request->input("pageNumber", 1);
        $offset = ($pageNumber - 1) * $limit;

        $subjects = Subject::query();

        if ($search) {
            $subjects->whereRaw("
            lower(
                concat(
                    coalesce(id, '')
                )
            )
            like lower(?)", ["%" . $search . "%"]);
        }

        $total = $subjects->count();
        $numberOfPages = ceil($total / $limit);
        $pageNumber = ceil($offset / $limit) + 1;

        $subjects = $subjects->orderBy("updated_at", "desc")
            ->offset($offset)
            ->limit($limit)
            ->get();

        $contents = $subjects->map(function ($s) {
            return [
                "id" => $s->id,
            ];
        });
        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "Subject",
            "subMenuItemActive" => "SUBJECT",
            "numberOfPages" => $numberOfPages,
            "pageNumber" => $pageNumber,
            "subjectList" => [
                "title" => "Mata Pelajaran",
                "columns" => ["Mata Pelajaran"],
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
            "menuItemActive" => "SUBJECT",
            "subMenuItemActive" => "SUBJECT",
            "subjectCreate" => true,
        ];
        return view("dashboard", $data);
    }
    public function editView(Request $request, string $id)
    {
        $me = $request->attributes->get("me");

        $Subject = Subject::query()->where("id", $id)->first();
        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "SUBJECT",
            "subMenuItemActive" => "SUBJECT",
            "subjectUpdate" => [
                "id" => $Subject->id,
            ]
        ];
        return view("dashboard", $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->input("id");

        $Subject = Subject::query()->find($id);
        if ($Subject != null) {
            throw new HttpException(403, "FORBIDDEN");
        }

        $Subject =  Subject::create([
            "id" => $id,
        ]);

        return redirect("/web/dashboard/subject");
    }
    public function update(Request $request, string $id)
    {

        $request->validate([
            'newId' => 'required',
        ]);


        $subject = Subject::query()->where("id", $id)->first();
        if ($subject == null) {
            throw new HttpException(404, "NOT_FOUND");
        }
        $subject->delete();

        $newId = $request->input("newId");
        $subject =  Subject::create([
            "id" => $newId,
        ]);

        return redirect("/web/dashboard/subject/" . $newId . "/edit");
    }

    public function delete(Request $request, string $id)
    {
        $subject = Subject::query()->where("id", $id)->first();
        if ($subject == null) {
            throw new HttpException(404, "NOT_FOUND");
        }
        $subject->delete();

        return redirect("/web/dashboard/subject/");
    }
}
