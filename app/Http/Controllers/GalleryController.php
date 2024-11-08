<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use File;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(){
        $data = array(
            "id" => "books",
            "menu" => "Gallery",
            "galleries" => Post::where('picture', '!=', '')->whereNotNull('picture')->orderBy('created_at', 'desc')->paginate(30)
        );

        return view('gallery.index')->with($data);
    }
    public function create(){
        return view('gallery.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
        if($request->hasFile('picture')){
            $fileNameWithExt = $request->file('picture')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid().time();
            $smallFileName = "small_{$basename}.{$extension}";
            $mediumFileName = "medium_{$basename}.{$extension}";
            $largeFileName = "large_{$basename}.{$extension}";
            $fileNameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $fileNameSimpan); 
        } else {
            $fileNameSimpan = "noimage.png";
        }
        $buku = new Post();
        $buku->picture = $fileNameSimpan;
        $buku->title = $request->input('title');
        $buku->description = $request->input('description');
        $buku->save();
        
        return redirect("/gallery")->with('success', 'Berhasil menambahkan data baru');
    }
    public function edit(string $id)
    {
        $post = Post::find($id);
        return view('gallery.edit',compact("post"));
        
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'picture' => 'image|nullable|max:1999'
        ]);
        $post = Post::findOrFail($id);
        if($request->hasFile('picture')){
            $previousPhoto = public_path()."/storage/posts_image/".$post->picture;
            try {
                if(File::exists($previousPhoto)){
                    File::delete($previousPhoto);
                }
            } catch (Exception $e){
                
            }
            $fileNameWithExt = $request->file('picture')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('picture')->getClientOriginalExtension();
            $basename = uniqid().time();
            $smallFileName = "small_{$basename}.{$extension}";
            $mediumFileName = "medium_{$basename}.{$extension}";
            $largeFileName = "large_{$basename}.{$extension}";
            $fileNameSimpan = "{$basename}.{$extension}";
            $path = $request->file('picture')->storeAs('posts_image', $fileNameSimpan); 
        } else {
            $path = null;
        }
        $post = Post::find($id);
        $post->title = $request->title;
        $post->description = $request->description;
        if($path){
            $post->picture = $fileNameSimpan;
        }
        $post->save();
        
        return redirect("/gallery");
    }
    public function destroy(string $id)
    {
        $post = Post::find($id);
        $photo = public_path()."/storage/posts_image/".$post->picture;
        try {
            if(File::exists($photo)){
                File::delete($photo);
            }
        } catch (Exception $e){

        }
        $post->delete();
        return redirect("/gallery");
    }
    public function destroyImage(string $id)
    {
        $post = Post::find($id);
        if($post->picture != "noimage.png"){
            $photo = public_path()."/storage/posts_image/".$post->picture;
            try {
                if(File::exists($photo)){
                    File::delete($photo);
                }
            } catch (Exception $e){
    
            }
            $post->picture = "noimage.png";
            $post->save();
        }
       
        return redirect("/gallery/update/$id")->with('success', 'Gambar berhasil dihapus');
    }
}
