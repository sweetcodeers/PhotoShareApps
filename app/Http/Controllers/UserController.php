<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use Auth;
use App\Models\Like;
use App\Models\Photo;
use App\Models\PhotoTag;
use App\Models\Tag;
use App\Models\User;

class UserController extends Controller
{
    
    public function index()
    {   
        $isLogin = Auth::check();
        $photos  = Photo::orderby('photos.created_at', 'desc')
                   ->join('users as u', 'u.id', '=', 'photos.user_id')
                   ->select(
                        'photos.id as id',
                        'photos.caption as caption',
                        'photos.photo as photo',
                        'photos.created_at as created_at',
                        'u.username as username',
                        'u.photo_profile as photo_profile'
                   )
                   ->get();
  
        foreach ($photos as $photo) {
            $tags = PhotoTag::where('photo_tags.photo_id', $photo->id)
                    ->join('tags as t', 't.id', '=', 'photo_tags.tag_id')
                    ->select('t.name as name')
                    ->get();
            $photo->tags = $tags;

            $likes = Like::where('photo_id', $photo->id)->count();
            $photo->likes = $likes;
        }
        


        return view('index', [
            'title'   => 'Welcome',
            'photos'  => $photos,
            'isLogin' => $isLogin
        ]);
    }
    public function register()
    {
        return view('register', [
            'title' => 'Register'
        ]);
    }
    public function registerAction(Request $request)
    {
        // Validation input
        $rules = [
            'username'         => 'required|unique:users',
            'email'            => 'required|unique:users',
            'password'         => 'required|min:8',
            'confirm_password' => 'required|same:password'
        ];
        $messages = [
            'required'               => 'cannot be empty',
            'unique'                 => ':attribute already used',
            'password.min'           => 'The password must consist of at least :min characters',
            'confirm_password.same'  => 'Password confirmation does not match'
        ];
        $request->validate($rules, $messages);

        // Input to Database
        $date = Carbon::now();
        $user = new User;
        $user->username   = $request->username;
        $user->email      = $request->email;
        $user->password   = Hash::make($request->password);
        $user->created_at = $date;
        $user->save();

        return redirect('login')->with('success', 'Anda telah berhasil mendaftar. Silahkan login!');
    }
    public function login()
    {
        return view('login', [
            'title' => 'Login'
        ]);
    }
    public function loginAction(Request $request)
    {
        // Validation input
        $rules = [
            'email'    => 'required',
            'password' => 'required'
        ];
        $messages = [
            'required' => 'cannot be empty',
        ];
        $request->validate($rules, $messages);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/photos');
        }

        return redirect()->back()->withErrors([
            'email' => 'Incorrect email or password.',
        ])->withInput($request->except('password'));
    }
   
    public function profil()
    {
        $user   = User::where('id', Auth::user()->id)
                  ->first();
        $photos = Photo::where('photos.user_id', Auth::user()->id)
                  ->select(
                    'photos.id as id',
                    'photos.photo as photo',
                    'photos.caption as caption',
                    'photos.created_at as created_at'
                  )
                  ->distinct()
                  ->get();
        foreach ($photos as $photo) {
            $tags         = PhotoTag::where('photo_tags.photo_id', $photo->id)
                            ->join('tags as t', 't.id', '=', 'photo_tags.tag_id')
                            ->select('t.name as name')
                            ->get();
            $photo->tags  = $tags;    
            $likes        = Like::where('photo_id', $photo->id)->count();
            $photo->likes = $likes;
        }
        return view('profil', [
            'title'  => 'Profil',
            'user'   => $user,
            'photos' => $photos
        ]);
    }
    public function profilUpdate(Request $request)
    {
        // Validation input
        $rules = [
            'photo_profile'   => 'image|mimes:jpg,png,jpeg|max:2048'
        ];
        $message = [
            'image'     => 'File must be of image data type',
            'mimes'     => 'Only allow images are png, jpg, and jpeg',
            'max'       => 'Uploaded images max. 2MB'
        ];
        $request->validate($rules, $message);
        
        $user =  User::where('id', Auth::user()->id)->first();
        $user->email    = $request->email;
        $user->username = $request->username;

        if($request->hasFile('photo_profile')){
            $file         = $request->file('photo_profile');
            $imageType    = $file->extension();
            $image_resize = Image::make($file)->resize(1000, 1000, function ($constraint) {
                                $constraint->aspectRatio();
                            })->encode($imageType);
            $user->photo_profile  = $image_resize;
        }

        $user->save();

        return redirect()->back()->with('updated', 'Profil berhasil di perbarui');
        
    }
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect('/');
    }

}
