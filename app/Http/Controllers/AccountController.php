<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
class AccountController extends Controller
{

    public function index()
    {

    }

    public function register()
    {
        return view('account.register');
    }

    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:5',
            'password_confirmation' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->route('account.register')->withInput()->withErrors($validator);
        }
        $obj = new User();
        $obj->name = $request->name;
        $obj->email = $request->email;
        $obj->password = Hash::make($request->password);
        $obj->save();
        return redirect('account/login')->with('success', 'Registration successfully..');
    }

    public function login()
    {
        return view('account.login');
    }

    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->route('account.login')->withInput()->withErrors($validator);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('account.profile');

        } else {
            return redirect()->route('account.login')->with('error', 'Either Email / Password Invalid..');
        }
    }


    public function profile()
    {
        $user = User::find(Auth::user()->id);        
        return view('account.profile', [
            'user' => $user
        ]);
    }

    // update user profile.
    public function updateProfile(Request $request)
    {       
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . Auth::user()->id . ',id',
        ];
        if (empty($request->image)) {
            $rules['image'] = 'image';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('account.profile')->withInput()->withErrors($validator);
        }
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        //  uploads image  :
        if (!empty($request->image)) {
            File::Delete(public_path('uploads/profile/'). $user->image);
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;
            $file->move(public_path('uploads/profile'), $imageName);
            $user->image = $imageName;
            $user->save();
            // create new image instance
            // $manager = new ImageManager(Driver::class);
            // $img = $manager->read(public_path('uploads/profile/' . $imageName)); // 800 x 600

            // $img->cover(150, 150);
            // $img->save((public_path('uploads/profile/thumb/' . $imageName)));
        }
        return redirect()->route('account.profile')->with('success', 'Profile Updated successfully..');

    }

    // logout function:
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login');

    }
}
