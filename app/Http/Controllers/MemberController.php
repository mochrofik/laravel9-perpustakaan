<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index(Request $request){


        $users = User::role('member'); // Retur
        if($request->search){

            $users->where('name', 'iLIKE', '%'.$request->search.'%' )
            ->orWhere('email', 'iLIKE', '%'.$request->search.'%'); // Retur
        }

        $users = $users->get(); // Retur

        return view('member.index', compact('users'))->with('i') ;
    }
}
