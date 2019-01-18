<?php

namespace Candidatos\Http\Controllers;

use Illuminate\Http\Request;
use Candidatos\User;
use Candidatos\RoleUser;
use Candidatos\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller {

    public function index(Request $request) {
        $request->user()->authorizeRoles(['super']);
        $users = DB::table('users')
                ->join('role_user', 'users.id', '=', 'role_user.user_id')
                ->select('users.*', 'role_user.id as role_user_id', 'role_user.role_id as role_id')
                ->get();
        $roles = Role::all();
        return view('user.index', compact('users', 'roles'));
    }

    /**
     * Permite cambiar el rol de un usuario
     * @param Request $request
     * @return type
     */
    public function changeRol(Request $request) {
        $request->user()->authorizeRoles(['super']);
        if ($request->ajax()) {
            $user = RoleUser::findOrFail($request->input('id'));
            $user->role_id = $request->input('option');
            $user->save();
            return response()->json("OK");
        }
    }

}
