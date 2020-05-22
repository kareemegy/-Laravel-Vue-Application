<?php

namespace App\Http\Controllers\APi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
        ]);
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'type' => $request['type'],
            'bio' => $request['bio'],
            'photo' => $request['photo'],
            'password' => Hash::make($request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request,[
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191'],
        ]);

        $user =  User::find($id);


          $user->name = $request['name'];
          $user->email = $request['email'];
          $user->type = $request['type'];
          $user->bio = $request['bio'];
          $user->photo = $request['photo'];

          if($request->has($request['password'])){
           $user->password =  Hash::make($request['password']);
          }
         
          $user->save();
          return ["user is edited"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user =  User::find($id);
        $user->delete();
        return ["message" => "User Is Deleted"];
    }

    public function profile(){
       
        return auth('api')->user();
       
    }
    public function updateProfile(Request $request){
        $this->validate($request,[
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191'],
            'password' => ['required', 'sometimes', 'min:6'],
        ]);

       $user = auth('api')->user();
       $current_photo = $user->photo;

      if($request->photo != $current_photo){
            $name = time().'.' . explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo'=>$name]);
        }

        if(!empty($request->password)){
            $request->merge(['password'=>Hash::make($request['password'])]);
        }

      $user->update($request->all());
      return ['msg'=>' Success'];

    }
}
