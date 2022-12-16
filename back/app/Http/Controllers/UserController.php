<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class UserController extends Controller
{
    private $cname = "UserController";
    public function index()
    {
        $tbl = User::with(['roles'])->get();

        $users = [];

        foreach ($tbl as $user) {
            $c = collect();
            $c->put("sample", "true");
            foreach ($user->roles as $role) {
                $c->put($role->name, true);
            }
            $user->roleList = $c;
            array_push($users, $user);
        }

        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::with('roles')->find($id);
        $roles = Role::all();

        if (!empty($user)) {
            $user_roles = [];
            $user_roles = collect($user_roles);

            foreach ($roles as $role) {
                if (DB::table('role_user')
                    ->where('role_id', $role->id)
                    ->where('user_id', $id)
                    ->exists()
                ) {
                    $user_roles->put($role->name, true);
                } else {
                    $user_roles->put($role->name, false);
                }
            }

            $user_roles = $user_roles->all();

            $user = collect($user);
            $user->put('roles', $user_roles);
            $user = $user->all();

            return response()->json($user);
        }

        return response()->json(['error' => 'Resource not found!'], 404);
    }

    public function store(Request $request)
    {
        try {
            $user = User::where('email', '=', $request->email)->first();

            if (empty($user)) {
                $data = DB::table('users')->insert([
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'remember_token' => str_random(10),
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' => \Carbon\Carbon::now()
                    ]
                ]);
                \Logger::instance()->log(
                    Carbon::now(),
                    $request->user_id,
                    $request->user_name,
                    $this->cname,
                    "store",
                    "message",
                    "Create new Client: " . $data
                );
                return response()->json($this->index());
            } else {

                return response()->json(['error' => 'Email already exists!'], 500);
            }
        } catch (Exception $ex) {
            \Logger::instance()->logError(
                Carbon::now(),
                $request->user_id,
                $request->user_name,
                $this->cname,
                "store",
                "Error",
                $ex->getMessage()
            );
            return response()->json(["error" => $ex->getMessage()], 500);
        }
    }

    public function UpdateUser(Request $request)
    {
        $id = $request->id;
        try {

            $tbl  = User::findOrFail($id);
            $logFrom = $tbl->replicate();

            if (empty($request->password)) {
                $logTo = DB::table('users')
                    ->where('id', $id)
                    ->update([
                        'email' => $request->email,
                        'updated_at' => \Carbon\Carbon::now()
                    ]);
            } else {
                $logTo = DB::table('users')
                    ->where('id', $id)
                    ->update([
                        'email' => $request->email,
                        'password' => bcrypt($request->password),
                        'updated_at' => \Carbon\Carbon::now()
                    ]);
            }

            if (!empty($request->roles)) {
                DB::table('role_user')->where('user_id', $id)->delete();
                $request->roles = (object) $request->roles;
                $this->setRoles($request->roles, $id);
            }
            \Logger::instance()->log(
                Carbon::now(),
                $request->id,
                $request->email,
                $this->cname,
                "update",
                "message",
                "update client id " . $id . "\nFrom: " . $logFrom . "\nTo: " . $logTo
            );
            return response()->json($this->index());
        } catch (\Exception $ex) {
            \Logger::instance()->logError(
                Carbon::now(),
                $request->id,
                $request->email,
                $this->cname,
                "update",
                "Error",
                $ex->getMessage()
            );
            return response()->json(["error" => $ex->getMessage()], 500);
        }
    }

    public function ResetPassword(Request $request)
    {
        try {
            DB::table('users')
                ->where('employee_id', $request->id)
                ->update([
                    'password' => bcrypt($request->password),
                    'updated_at' => \Carbon\Carbon::now()
                ]);
            return "ok";
        } catch (\Exception $ex) {
            return response()->json(['error' => $ex->getMessage()], 500);
        }
    }

    public function showSearch(Request $request)
    {
        $users = User::where('name', 'like', '%' . $request->user . '%')->get();
        return response()->json($users);
    }

    public function getUser($email)
    {


        $user = User::with(['employee.branch'])
            ->where('email', '=', $email)->first();
        return response()->json($user);
    }

    public function getApplication($type, $approve_id)
    {
    }

    public function getRole($id)
    {
        $user = User::with('roles')->find($id);
        $roles = Role::all();

        if (!empty($user)) {
            $user_roles = [];
            $user_roles = collect($user_roles);

            foreach ($roles as $role) {
                if (DB::table('role_user')
                    ->where('role_id', $role->id)
                    ->where('user_id', $id)
                    ->exists()
                ) {
                    $user_roles->put($role->name, true);
                } else {
                    $user_roles->put($role->name, false);
                }
            }

            $user_roles = $user_roles->all();

            $user = collect($user);
            $user->put('roles', $user_roles);
            $user = $user->all();

            return response()->json($user);
        }

        return response()->json(['error' => 'Resource not found!'], 404);
    }
}
