<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\User;

class UsersApiController extends Controller
{
    public function index()
    {
        $users = User::all();

        return $users;
    }

    public function store(StoreUserRequest $request)
    {
        return User::create($request->all());
    }

    public function updatepass(Request $request)
    {
        $input = $request->all();
        $userid = Auth::user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first());
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = array("status" => 400, "message" => "Check your old password.");
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.");
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("status" => 200, "message" => "Password updated successfully.");
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg);
            }
        }
        return \Response::json($arr);
    }


    public function show(User $user)
    {
        return $user;
    }
    public function getprovinsi(User $user)
    {
        return $user;
    }
    public function getpenguruskab(User $user)
    {
        return $user;
    }
    public function getanggotakab(User $user)
    {
        return $user;
    }
    public function getkategori(User $user)
    {
        return $user;
    }
    public function getartikel(User $user)
    {
        return $user;
    }
    public function getprofile(User $user)
    {
        return $user;
    }

    public function destroy(User $user)
    {
        return $user->delete();
    }
}
