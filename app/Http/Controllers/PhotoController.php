<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Carbon\Carbon;
use Auth;
use App\Models\Like;
use App\Models\Photo;
use App\Models\PhotoTag;
use App\Models\Tag;
use App\Models\User;

class PhotoController extends Controller
{
    public function index()
    {
        $user   = User::where('id', Auth::user()->id)->first();
        $photos = Photo::orderby('photos.created_at', 'desc')
                  ->join('users as u', 'u.id', '=', 'photos.user_id')
                  ->join('photo_tags as pt', 'pt.photo_id', '=', 'photos.id')
                  ->join('tags as t', 't.id', '=', 'pt.tag_id')
                  ->select(
                        'u.username as username',
                        'u.photo_profile as photo_profile',
                        'photos.id as id',
                        'photos.photo as photo',
                        'photos.caption as caption'
                    )
                  ->get();
        foreach ($photos as $photo) {
            $date         = Carbon::parse($photo->created_at)->formatLocalized('%d %b %Y %H:%M');
            $tags         = PhotoTag::where('photo_tags.photo_id', $photo->id)
                            ->join('tags as t', 't.id', '=', 'photo_tags.tag_id')
                            ->select('t.name as name')
                            ->get();
            $photo->tags  = $tags;
            $likes        = Like::where('photo_id', $photo->id)->count();
            
            $photo->likes = $likes;
        }

        
        return view('photo.index', [
            'title'   => 'Photos',
            'photos'  => $photos,
            'user'    => $user,
            'date'    => $date
        ]);
    }
    public function create()
    {
        if(Auth::check()){
            $user   = User::where('id', Auth::user()->id)->first();
            return view('photo.create', [
                'title' => 'Create Photo',
                'user'  => $user
            ]);
        }else{
            return redirect('login');
        }
        
    }
    public function store(Request $request)
    {
        // Validation input
        $rules = [
            'caption' => 'required',
            'tag'     => 'required',
            'photo'   => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ];
        $message = [
            'required' => 'cannot be empty',
            'image'     => 'File must be of image data type',
            'mimes'     => 'Only allow images are png, jpg, and jpeg',
            'max'       => 'Uploaded images max. 2MB'
        ];
        $request->validate($rules, $message);
        
        $date = Carbon::now();
        $photos = new Photo;
        $photos->user_id    = Auth::user()->id;
        $photos->caption    = $request->caption;
        $photos->created_at = $date;
        if($request->hasFile('photo')){
            $file         = $request->file('photo');
            $imageType    = $file->extension();
            $image_resize = Image::make($file)->resize(1000, 1000, function ($constraint) {
                                $constraint->aspectRatio();
                            })->encode($imageType);
            $photos->photo  = $image_resize;
        }
        $photos->save();
        $tag = new Tag;
        $tag->name       = $request->tag;
        $tag->created_at = $date;
        $tag->save();

        $photo_tag = new PhotoTag;
        $photo_tag->photo_id = $photos->id;
        $photo_tag->tag_id   = $tag->id;
        $photo_tag->save();

        return redirect()->route('photo.list')->with('success', 'Photo uploaded successfully');
    }

    public function detail($id)
    {
        $user   = User::where('id', Auth::user()->id)->first();
        $photo = Photo::where('photos.id', $id)
                 ->join('users as u', 'u.id', '=', 'photos.user_id')
                 ->join('photo_tags as pt', 'pt.photo_id', '=', 'photos.id')
                 ->join('tags as t', 't.id', '=', 'pt.tag_id')
                 ->select(
                    'photos.id as id',
                    'photos.caption as caption',
                    'photos.photo as photo',
                    'photos.created_at as created_at',
                    'u.username as username',
                    't.id as tag_id',
                    't.name as tag'
                 )
                 ->first();
        return view('photo.detail', [
            'title'  => 'Detail Photo',
            'photo'  => $photo,
            'user'   => $user
        ]);
    }
    public function update(Request $request, $id)
    {
        // Validation input
        $rules = [
            'photo'   => 'image|mimes:jpg,png,jpeg|max:4048'
        ];
        $message = [
            'image'     => 'File must be of image data type',
            'mimes'     => 'Only allow images are png, jpg, and jpeg',
            'max'       => 'Uploaded images max. 2MB'
        ];
        $request->validate($rules, $message);
        
        $photo = Photo::findOrFail($id);
        $date  = Carbon::now();

        if ($request->caption === $photo->caption && !$request->hasFile('photo')) {
            return redirect()->back()->with('warning', 'No changes have been made.');
        }
       
        $photo->caption    = $request->caption;
        $photo->user_id    = Auth::user()->id;
        $photo->updated_at = $date;

        if($request->hasFile('photo')){
            $file         = $request->file('photo');
            $imageType    = $file->extension();
            $image_resize = Image::make($file)->resize(1000, 1000, function ($constraint) {
                                $constraint->aspectRatio();
                            })->encode($imageType);
            $photo->photo = $image_resize;
        }
        $photo->update();

        $tag = Tag::where('id', $request->tag_id)->firstOrFail();
        $tag->name       = $request->tag;
        $tag->updated_at = $date;
        $tag->update();

        $photo_tag = PhotoTag::where('photo_id', $photo->id)->firstOrFail();
        $photo_tag->tag_id     = $tag->id;
        $photo_tag->updated_at = $date;
        $photo_tag->update();

        return redirect()->back()->with('success', 'Photo updated successfully.');
    }
    public function delete($id)
    {
        $photo     = Photo::find($id);
        $photo_tag = PhotoTag::where('photo_id', $id)->first();
        $tag       = Tag::where('id', $photo_tag->tag_id)->first();

        $tag->delete();
        $photo_tag->delete();
        $photo->delete();


        return redirect('profil')->with('delete', 'Photo deleted successfully.');
    }
    public function like(Request $request, $id)
    {
        // Check like photo
        $existingLike = Like::where('photo_id', $id)
                        ->where('user_id', auth()->user()->id)
                        ->first();

        if (!$existingLike) {
            Like::create([
                'photo_id' => $id,
                'user_id'  => Auth::user()->id,
            ]);
        }

        return redirect()->back();
    }

    public function unlike(Request $request, $id)
    {
        // Check like photo
        $existingLike = Like::where('photo_id', $id)
                        ->where('user_id', auth()->user()->id)
                        ->first();

        if ($existingLike) {
            $existingLike->delete();
        }

        return redirect()->back();
    }

}
