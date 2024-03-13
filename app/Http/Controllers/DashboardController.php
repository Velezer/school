<?php

namespace App\Http\Controllers;

use App\Models\Enums\UserRole;
use App\Models\User;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->attributes->get("me");

        $data = [
            "me" => [
                "id" => $user->id,
                "name" => $user->name,
                "role" => $user->role
            ],
            "menuItemActive" => "DASHBOARD",
            "isDashboardAdmin" => true,
            "contentWrapper" => [
                "userName" => $user->name,
                "countAdmin" => User::query()->where("role", UserRole::ADMIN->value)->count(),
                "countTeacher" => User::query()->where("role", UserRole::TEACHER->value)->count(),
                "countStudent" => User::query()->where("role", UserRole::STUDENT->value)->count(),
                "countUser" => User::query()->count(),
            ]
        ];
        return view("dashboard", $data);
    }
 
    public function dashboardReportDetail(Request $request)
    {
        $data = [
            "menuItemActive" => "REPORT",
            "reportDetail" => [
                "name" => "monkeydluffy",
                "columns" => [
                    "Mata Pelajaran",
                    "KKM",
                    "Nilai (Angka)",
                    // "Nilai (Huruf)",
                    "Rata-Rata Kelas",
                    "Keterangan",
                ],
                "contents" => [
                    [
                        "subject" => "Agama",
                        "kkm" => "77",
                        "grade" => "0",
                        // "gradeLetter" => "Tidak Ada Akhlak",
                        "classRate" => "90",
                        "Notes" => "Tidak Ada Akhlak",
                    ],
                    [
                        "subject" => "Matematika",
                        "kkm" => "77",
                        "grade" => "0",
                        // "gradeLetter" => "Ga punya otak",
                        "classRate" => "90",
                        "Notes" => "Akhlak ga ada otak pun takada",
                    ]
                ]
            ]
        ];
        return view("dashboard", $data);
    }

}
