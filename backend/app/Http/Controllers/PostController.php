<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

//ファイル操作に必要
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()->paginate(5);
        return view('posts.index', compact('posts'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show e form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //エラーチェック
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            //'image_url' => 'required|max:10240|mimes:jpg,jpeg,gif,png',
            'image_file' => 'required',
        ]);

        /*
        $image = new Image();
        $uploadImg = $request->image_fileS;
        if($uploadImg->isValid()) {
            $filePath = $uploadImg->store('public');
            $image->image = str_replace('public/', '', $filePath);
        }
        $image->save();
        */
        

        $uploadImg = $request->image_file;
        if ($uploadImg->isValid()) {
            //保存
            $imagePath = Storage::put('public/posts', $uploadImg);
            //$imagePath  = Storage::disk('s3')->putFile('/', $file, 'public');

            //publicは不要なので削除した状態に変換する。
            $imagePath = str_replace('public/', '', $imagePath);
        }


        //全て保存する。
        //画像の保存により単純な保存でなくなったので変更
        //Post::create($request->all());
        //指定した物に変更して保存

        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_url' => $imagePath,
        ]);

        //成功のメッセージを出しつつ戻る。
        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);


        $uploadImg = $request->image_file;
        if (!empty($uploadImg)) {
            //保存
            $imagePath = Storage::put('public/posts', $uploadImg);
            //$imagePath  = Storage::disk('s3')->putFile('/', $file, 'public');

            //publicは不要なので削除した状態に変換する。
            $imagePath = str_replace('public/', '', $imagePath);

            $update = [
                'title' => $request->title,
                'description' => $request->description,
                'image_url' => $imagePath,
            ];
        } else {

            $update = [
                'title' => $request->title,
                'description' => $request->description,
            ];
        }


        //$post->update($request->all());

        //updateを実行
        Post::where('id', $id)->update($update);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully');
    }
}
