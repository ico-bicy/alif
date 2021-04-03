<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = DB::table('users')->orderBy('id', 'desc')->paginate(50);
        return view('home', compact('users'));
    }

    public function update($id)
    {

        $user = DB::table('users')->where('id', $id)->first();

        return view('update', compact('user'));
    }

    public function editUser($id, Request $req){
        $messages = array(
            'required' => 'Поле :attribute должно быть заполнено.',
        );

        $this->validate($req, [
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'additional_email' => ['string', 'email', 'max:255', 'unique:users'],
            'contact_phone' => ['required', 'integer', 'unique:users'],
            'additional_contact_phone' => ['integer', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);

        $data = $req->all();
        $user = User::find($id);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->additional_email = $data['additional_email'];
        $user->contact_phone = $data['contact_phone'];
        $user->additional_contact_phone = $data['additional_contact_phone'];

        if(!empty($data['password'])){
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('home');
    }

    public function search(Request $request) {
        $search = $request->search;
        $users = User::query()->where('name', 'LIKE', "%{$search}%")->orderBy('name', 'desc')->paginate(50);
        return view('home', compact('users'));
    }

}
