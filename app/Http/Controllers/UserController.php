<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Services\UserService;
use App\Models\Update;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    /**
     * Authenticate Login
     *
     * @param UserLoginRequest $request
     * @return View dashboard
     * @return View login with password error
     */
    public function authenticate(UserLoginRequest $request)
    {
        $user = User::where('username', $request['username'])->first();
        $auth = Auth::attempt(['email' => $user->email, 'password' => $request['password']]);

        if ($auth && ($user->status == true)) {

            // $user->outlet_id = $request->outlet_id;
            // $user->save();

            $request->session()->regenerate();
            Session::put('user', $user);

            $roles = $user->getRoleNames();
            $role = $roles[0];
            Session::put('role', $role);

            $permission = $user->getPermissionsViaRoles()->pluck('name')->toArray();
            Session::put('permissions', $permission);

            return redirect()->intended(route('dashboard'));
        }
        return back()->withErrors([
            'password' => 'Password tidak cocok.'
        ]);
    }

    /**
     * Store New User
     *
     * @param UserCreateRequest $request
     * @return View dashboard
     */
    public function insert(UserCreateRequest $request)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Menambahkan Karyawan';
        });
        if ($permissionExist) {
            User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'email' => $request->email,
                'outlet_id' => $request->outlet_id,
            ])->assignRole($request->role);
            //need dashboard page
            return redirect()->intended(route('menu-karyawan'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function show($id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Melihat Detail Karyawan';
        });
        if ($permissionExist) {
            $user = User::find($id);
            return [
                'status' => 200,
                $user,
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find(auth()->id());
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Karyawan';
        });
        if ($permissionExist) {
            $user = User::find($id);
            $user->username = $request->username;
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->email = $request->email;
            $user->status = $request->status;
            $user->outlet_id = $request->outlet_id;
            $user->changeRole($request->role);
            $user->save();
            return redirect()->intended(route('menu-karyawan'));
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function delete($id)
    {
        User::find($id)->delete();
    }

    public function updateOutlet(Request $request)
    {

        $user = User::find(Auth::user()->id);
        $user->outlet_id = $request->outlet_id;
        $user->save();
        return [
            'status' => 200,
            'message' => 'Success'
        ];
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        $permissions = $user->getPermissionsViaRoles();
        $permissionExist = collect($permissions)->first(function ($item) {
            return $item->name === 'Mengubah Data Password Karyawan';
        });
        if ($permissionExist) {
            if ($request->new_password != $request->new_password_confirmation) {
                return [
                    'status' => 400,
                    'message' => 'Konfirmasi password salah'
                ];
            }

            $new = Hash::make($request->new_password);
            $user->password = $new;
            $user->save();
            return [
                'status' => 200,
                'message' => 'Success'
            ];
        } else {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSION');
        }
    }

    public function logout(Request $request)
    {
        $role = User::getRole(Auth::id());
        if ($role == "administrator") {
            // $user = User::find(Auth::id());
            // $user->outlet_id = null;
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
