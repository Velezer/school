<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Str;


class SubmissionController extends Controller
{

    public function detailView(Request $request, string $id)
    {

        $me = $request->attributes->get("me");


        $submission = Submission::query()->where("id", $id)->first();
        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "SUBMISSION",
            "subMenuItemActive" => "SUBMISSION",
            "submissionDetail" => [
                "data" => [
                    "id" => $submission->id,
                    "start_at" => $submission->start_at,
                    "end_at" => $submission->end_at,
                    "subject" => $submission->subject,
                    "classroom" => $submission->classroom,
                    "period" => $submission->period,
                ]
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

        $assessmentId = $request->input("assessmentId");

        $submissions = Submission::query();
        if ($assessmentId) {
            $submissions->where("assessment_id", $assessmentId);
        }

        $search = $request->input("search");
        if ($search) {
            $submissions->join('users', 'submissions.user_id', '=', 'users.id')
                ->join('assessments', 'submissions.assessment_id', '=', 'assessments.id')
                ->whereRaw("
                    lower(
                        concat(
                            coalesce(users.name, ''),
                            coalesce(assessments.name, '')
                        )
                    )
                    like lower(?)", ["%" . $search . "%"]);
        }

        $total = $submissions->count();
        $numberOfPages = ceil($total / $limit);
        $pageNumber = ceil($offset / $limit) + 1;


        $submissions = $submissions
            ->orderBy("submissions.updated_at", "desc")
            ->offset($offset)
            ->limit($limit)
            ->get();

        $contents = $submissions->map(function (Submission $submission) {
            return [
                "id" => $submission->id,
                "userName" => $submission->user->name,
                "assessmentId" => $submission->assessment->id,
                "assessmentName" => $submission->assessment->name,
                "createdAt" => $submission->created_at,
            ];
        });


        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "SUBMISSION",
            "subMenuItemActive" => "SUBMISSION",
            "numberOfPages" => $numberOfPages,
            "pageNumber" => $pageNumber,
            "assessments" => Assessment::all()->map(function (Assessment $a) {
                return [
                    "id" => $a->id,
                    "name" => $a->name,
                ];
            }),
            "submissionList" => [
                "name" => "submission",
                "title" => "Submission",
                "columns" => ["siswa", "assessment", "waktu pengumpulan"],
                "contents" => $contents,
            ]
        ];
        return view("dashboard", $data);
    }

    public function createView(Request $request)
    {
        $user = $request->attributes->get("me");

        $assessmentId = $request->input("assessmentId");
        $assessment = Assessment::query()->where("id", $assessmentId)->first();
        $me = $request->attributes->get("me");

        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "SUBMISSION",
            "subMenuItemActive" => "SUBMISSION",
            "submissionCreate" => true,
            "assessment" => [
                "id" => $assessment->id,
                "name" => $assessment->name,
            ],
            "user" => [
                "name" => $user["name"]
            ],
        ];
        return view("dashboard", $data);
    }

    public function create(Request $request)
    {

        $request->validate([
            'assessmentId' => 'required',
        ]);

        $user = $request->attributes->get("me");

        $assessmentId = $request->input("assessmentId");
        $assessment = Assessment::query()->where("id", $assessmentId)->first();

        $path = $request->file('file')->store(
            'submissions',
            'public'
        );

        $id = Str::uuid();

        $submission = Submission::query()->find($id);
        if ($submission != null) {
            throw new HttpException(409, "CONFLICT");
        }

        Submission::create([
            "id" => $id,
            "file" => $path,
            "user_id" => $user["id"],
            "assessment_id" => $assessmentId,
        ]);

        return redirect("/web/dashboard/submission");
    }


    public function delete(Request $request, string $id)
    {
        $me = $request->attributes->get("me");

        $submission = Submission::query()
            ->where("id", $id)
            ->where("user_id", $me->id)
            ->first();
        if ($submission == null) {
            throw new HttpException(404, "NOT_FOUND");
        }
        $submission->delete();

        return redirect("/web/dashboard/submission/");
    }
}
