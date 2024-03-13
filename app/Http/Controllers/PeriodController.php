<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PeriodController extends Controller
{


    public function listView(Request $request)
    {
        $me = $request->attributes->get("me");

        $limit = 10;
        $pageNumber = $request->input("pageNumber", 1);
        $offset = ($pageNumber - 1) * $limit;

        $total = Period::count();
        $numberOfPages = ceil($total / $limit);
        $pageNumber = ceil($offset / $limit) + 1;

        $periods = Period::orderBy("updated_at", "desc")
            ->offset($offset)
            ->limit($limit)
            ->get();
        $contents = $periods->map(function ($p) {
            return [
                "id" => $p->id,
            ];
        });
        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "PERIOD",
            "subMenuItemActive" => "PERIOD",
            "numberOfPages" => $numberOfPages,
            "pageNumber" => $pageNumber,
            "periodList" => [
                "name" => "period",
                "title" => "Period",
                "columns" => ["id"],
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
            "menuItemActive" => "PERIOD",
            "subMenuItemActive" => "PERIOD",
            "periodCreate" => true,
        ];
        return view("dashboard", $data);
    }

    public function create(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $id = $request->input("id");

        $user = User::query()->find($id);
        if ($user != null) {
            throw new HttpException(404, "NOT_FOUND");
        }

        $user =  Period::create([
            "id" => $id
        ]);

        return redirect("/web/dashboard/period");
    }


    public function delete(Request $request)
    {
        $id = $request->input("id");
        $period = Period::query()->where("id", $id)->first();
        if ($period == null) {
            throw new HttpException(404, "NOT_FOUND");
        }
        $period->delete();

        return redirect("/web/dashboard/period/");
    }
}
