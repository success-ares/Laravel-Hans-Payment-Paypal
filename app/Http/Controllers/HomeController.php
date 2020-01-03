<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class HomeController extends Controller
{
    public function index() {
        return view('home');
    }

    public function save(Request $request) {

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $system = $request->input("system");

        $data = [
            "name"=>$name, 
            "email"=>$email,
            "password"=>$password,
            "system"=>$system
        ];

        $int = (int)$system;

        $prior_existed = DB::table('users')
            ->where('name','LIKE',$name)
            ->where('email','LIKE',$email)
            ->where('password','LIKE',$password)
            ->where('paid','LIKE',$int)
            ->get();

            

        if(count($prior_existed) > 0) {
            return response()->json(['success'=>'already booked for subscription.', 'data'=>$data]);; //already existed
        }

        

        $User = new User;
        $User->name = $name;
        $User->email = $email;
        $User->password = $password;
        $User->paid = $int;
        
        $User->save();


        return response()->json(['success'=>'Got Book Request for subscription.', 'data'=>$data]); //book success

    }


    
}
