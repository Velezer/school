<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Enums\UserRole;
use App\Models\Period;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;


class UserController extends Controller
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function detailView(Request $request, string $id)
    {
        $me = $request->attributes->get("me");

        $user = User::query()->where("id", $id)->first();
        $data = [
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "USER",
            "subMenuItemActive" => $user->role == "ADMIN" ? "USER" : $user->role,
            "periods" => Period::all()->map(function ($p) {
                return $p->id;
            }),
            "classrooms" => Classroom::all()->map(function ($p) {
                return $p->id;
            }),
            "userDetail" => [
                "id" => $user->id,
                "avatar" => $user->avatar,
                "role" => $user->role,
                "name" => $user->name,
                "address" => $user->address,
                "classroom" => $user->classroom,
                "gender" => $user->gender,
                "religion" => $user->religion,
                "dob" => $user->dob,
                "period" => $user->period,
            ]
        ];
        return view("dashboard", $data);
    }

    public function createView(Request $request)
    {
        $me = $request->attributes->get("me");
        $role = Str::contains(url()->current(), 'teacher') ? "TEACHER" : "STUDENT";

        $data = [
            "readonly" => false,
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "USER",
            "subMenuItemActive" => $role,
            "periods" => Period::all()->map(function ($p) {
                return $p->id;
            }),
            "classrooms" => Classroom::all()->map(function ($p) {
                return $p->id;
            }),
            "userDetail" => [
                "role" => $role
            ]
        ];
        return view("dashboard", $data);
    }

    public function editView(Request $request, string $id)
    {
        $me = $request->attributes->get("me");

        $user = User::query()->where("id", $id)->first();
        $data = [
            "readonly" => false,
            "me" => [
                "id" => $me->id,
                "avatar" => $me->avatar,
                "name" => $me->name,
                "role" => $me->role
            ],
            "menuItemActive" => "USER",
            "subMenuItemActive" => $user->role == "ADMIN" ? "USER" : $user->role,
            "periods" => Period::all()->map(function ($p) {
                return $p->id;
            }),
            "classrooms" => Classroom::all()->map(function ($p) {
                return $p->id;
            }),
            "userDetail" => [
                "id" => $user->id,
                "avatar" => $user->avatar,
                "role" => $user->role,
                "name" => $user->name,
                "address" => $user->address,
                "classroom" => $user->classroom,
                "gender" => $user->gender,
                "religion" => $user->religion,
                "dob" => $user->dob,
                "period" => $user->period,
            ]
        ];
        return view("dashboard", $data);
    }

    public function create(Request $request)
    {

        $request->validate([
            'redirectUrl' => 'required',
            'id' => 'required',
            'name' => 'required',
            'role' => 'required',
        ]);

        $role = $request->input("role");
        if ($role == "ADMIN") {
            throw new HttpException(409, "CONFLICT");
        }

        $id = $request->input("id");

        $user = User::query()->find($id);
        if ($user != null) {
            throw new HttpException(409, "CONFLICT");
        }

        $user =  User::create([
            "id" => $id,
            "password" => bcrypt("password"),
            "role" => UserRole::from($role),
            "name" => $request->input("name"),
            "classroom" => $request->input("classroom"),
            "address" => $request->input("address"),
            "gender" => $request->input("gender"),
            "religion" => $request->input("religion"),
            "dob" => $request->input("dob"),
            "period" => $request->input("period"),
        ]);

        if ($role == "TEACHER") {
            return redirect(route("webTeacherListView"));
        }

        return redirect(route("webStudentListView"));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'redirectUrl' => 'required',
            'name' => 'required',
        ]);


        $user = User::query()->where("id", $id)->first();
        if ($user == null) {
            throw new HttpException(403, "FORBIDDEN");
        }

        $path = "";
        if ($request->file('avatar')) {
            $path = $request->file('avatar')->store(
                'avatar',
                'public'
            );
        }

        $user->avatar = $path;
        $user->name = $request->input("name");
        $user->classroom = $request->input("classroom");
        $user->address = $request->input("address");
        if ($request->input("password")) {
            $user->password = $request->input("password");
        }
        $user->gender = $request->input("gender");
        $user->religion = $request->input("religion");
        $user->dob = $request->input("dob");
        $user->period = $request->input("period");
        $user->save();


        return redirect($request->input("redirectUrl"));
    }

    public function signOut(): RedirectResponse
    {
        return redirect("/web/signIn")
            ->cookie("x-token", null, -1, "/");
    }

    public function signIn(Request $request): RedirectResponse | Response
    {
        $request->validate([
            'id' => 'required',
            'password' => 'required',
        ]);

        $id = $request->input("id");
        $password = $request->input("password");

        $user = User::where('id', $id)->first();
        if (!$user || !Hash::check($password, $user->password)) {
            return redirect("/web/signIn/failed");
        }

        $token = Auth::guard("jwt")->login($user);
        if (!$token) {
            return redirect("/web/signIn/failed");
        }

        return redirect("/web/dashboard")
            ->cookie("x-token", $token, 60, "/");
    }

    public function signUp(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);

        $user = $this->userService->signUp(
            $request->input("id"),
            $request->input("password"),
            $request->input("role"),
            $request->input("name"),
        );

        return redirect("/web/signIn");
    }
}
