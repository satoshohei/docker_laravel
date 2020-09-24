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


        //全て保存する。
        //画像の保存により単純な保存でなくなったので下記に変更
        //Post::create($request->all());
        /*
        if ($file = $request->image_file) {
            $fileName = time() . $file->getClientOriginalName();
            $target_path = public_path('uploads/');
            $file->move($target_path, $fileName);
        } else {
            $fileName = "";
        }
        */

        //s3に画像を保存。第一引数はs3のディレクトリ。第二引数は保存するファイル。
        //第三引数はファイルの公開設定。
        //$path = Storage::disk('s3')->putFile('/', $file, 'public');

        //ローカルにファイル保存
        //Storage::disk('local')->put('file.txt', 'Contents');





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
        if($uploadImg->isValid()) {
            //保存
            $imagePath = Storage::put('public/articles', $uploadImg);
            //publicは不要なので削除した状態に変換する。
            $imagePath = str_replace('public/', '', $imagePath);
        }


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
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $post->update($request->all());

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
