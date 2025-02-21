<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getAllUsers()
    {
        return view('admin.users', ['users'=>User::all()]);
    }

    public function addUser(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed'],
            'role' => ['required', 'string', 'lowercase', 'in:admin,user']
        ]);

        $password = Hash::make($request->password);

        $user = new User;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->prof_img = "";
        $user->password = $password;
        $user->role = $request->role;
        $user->save();

        return redirect(route('users'));
    }

    public function updateUser(Request $request, string $id)
    {
        $updatedFields = [];
        $user = User::where('id', $id)->first();
        $username = $request->username;
        $role = $request->role;
        $email = $request->email;

        if($username and $username!=$user->username){
            $request->validate(["username"=>['required', 'string', 'max:255']]);
            $updatedFields["username"]=$username;
        }


        if($role and $role!=$user->role){
            $request->validate([
                'role' => ['required', 'string', 'lowercase', 'in:admin,user']
            ]);

            $updatedFields["role"]=$role;
        }

        if($email and $email!=$user->email){
            $request->validate([
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            ]);
            $updatedFields["email"]=$email;
        }

        if(count($updatedFields)>0){
            User::where('id', $id)->update($updatedFields);
        }

        return redirect(route("users"));
    }

    public function deleteUser(string $id){
        User::where('id', $id)->delete();
        return redirect(route("users"));
    }
}
