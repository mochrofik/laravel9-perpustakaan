<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function register(Request $request)
    {

        try{
        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $user = User::findOrFail($user->id);
        $member = Role::findOrFail(2);
        $user->assignRole($member);

        return redirect('/')->with('success', 'Registered Completed');
    } catch (\Exception $e) {
      
        return redirect('/register')->with('error', 'Registered Error');
    }

}
    
}
