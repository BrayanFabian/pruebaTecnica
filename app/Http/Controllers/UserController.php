<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;
use App\Role;
use App\Http\Controllers\Auth\RegisterController;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{

    public function getUsers()
    {
      $users=User::select(['id','name','email','created_at'])->get();
      $dt= Datatables::of($users)
      ->editColumn('created_at', function ($user) {
                $date=new \DateTime($user->created_at);
                return $date->format('d-m-Y h:i:s a');
      })
      ->addColumn('actions',function ($user){
        $d='<div class="btn btn-warning glyphicon glyphicon-pencil edit"></div>
            <div class="btn btn-danger glyphicon glyphicon-trash delete"></div>';
        return $d;
      })
      ->addColumn('role',function ($user){
        if (($user->roles()->first())!=null) {
          $role=$user->roles()->first()->description;
          return $role;
        }
      })
      ->rawColumns(['actions'])
      ->make(true);

      return $dt;
    }

    /**
 * Store a new user.
 *
 * @param  Request  $request
 * @return Response
 */
public function store(UserRequest $request)
{
    if ($request->ajax()) {

      $user = User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => bcrypt($request['password']),
      ])->roles()->attach(Role::where('name', $request['role'])->first());
        return response()->json(['status'=>'ok']);
    }
}
/**
* Edit user.
*
* @param  Request  $request
* @return Response
*/
public function update(Request $request,$id)
{
//  $this->validate($request,[ 'name'=>'required|string|min:6|max:255', 'email'=>'required|string|email|max:255|unique:users,email,'.$id, 'password'=>'sometimes|string|min:6',]);
if ($request->ajax()) {
  $user = User::findOrFail($id);
  $user->name=$request['name'];
  $user->email=$request['email'];
  if ($user->password!="") {
    $user->password=bcrypt($request['password']);
  }
  $user->roles()->attach(Role::where('name', $request['role'])->first());
  $user->save();
    return response()->json(['status'=>'ok']);
}
}

public function delete($id)
{
  $user = User::findOrFail($id);
  $user->delete();
  return response()->json(['status'=>'ok']);

}
}
