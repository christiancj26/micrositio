<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

use App\Photo;
use App\Post;

class PhotosController extends Controller
{
	public function get(Post $post){
		if (request()->wantsJson()) {
			return $post->photos;
		}else{
           return response()->json(['error' => 'Unauthorized'], 401, []);
        }
	}

    public function store(Post $post){

        $this->validate(request(), [
            'photo' => 'required|image|max:2048'
        ]);
        $imageUrl  = request()->file('photo')->store('storage/posts');
        $post->photos()->create([
            'url' => $imageUrl,
        ]);
        //Resize image here
            /*$thumbnailpath = public_path($imageUrl);
            $img = new Redimencionar();
            $img->redimencionarImgPost($thumbnailpath);*/
    }

    public function destroy(Photo $photo){
    	if (request()->wantsJson()) {
			$photo->delete();
            return response()->json(['success' => 'Se eliminó correntamente'], 200, []);
		}else{
           return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }
}
