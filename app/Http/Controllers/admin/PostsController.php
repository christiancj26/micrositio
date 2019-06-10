<?php

namespace App\Http\Controllers\admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Post;
use App\Region;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostsController extends Controller
{

    public function index()
    {

        $posts =  Post::allowed()->orderBy('id', 'desc')->paginate(7);

        if (request()->wantsJson()) {
            return response()->json($posts, 200);
        }else{
           return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function store(Request $request)
    {
        $this->authorize('create', new Post);


        if (request()->wantsJson()) {
            $this->validate($request, ['title' => 'required|min:3',]);
            $post = Post::create($request->all());
            Cache::flush();
            /*event(new PostCreated($post));*/
            return response()->json($post, 200);
        }else{
           return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function edit(post $post)
    {
        $this->authorize('update', $post);

        $key = "posts.edit." . $post->id;

        $datos = Cache::rememberForever($key, function() use($post){
            return [
                'categories'            => Category::all(),
                'tags'                  => Tag::all(),
                'post'                  => $post,
                'post_tags'             => $post->tags->pluck('id')
            ];
        });

        if (request()->wantsJson()) {
            return response()->json($datos, 200);
        }else{
           return response()->json(['error' => 'Unauthorized'], 401, []);
        }
    }

    public function update(Post $post, StorePostRequest $request)
    {
        $this->authorize('update', $post);
        $post->update($request->all());
        Cache::flush();
        //tags
        $post->syncTags($request->get('tags'));
        /*return redirect()->route('admin.posts.edit', $post)->with('flash','Tu publicación ha sido guardada');*/
        return $datos = [
            'post'                  => $post,
            'post_tags'             => $post->tags->pluck('id')
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function destroy(Post $post){
        $this->authorize('delete', $post);
        $post->delete();
        Cache::flush();
    }
}
