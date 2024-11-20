<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Exception;
use File;
use Illuminate\Http\Request;


/**
* @OA\Info (
*   description="API Documentation untuk Sistem Informasi Buku PPW2", 
*   version="0.0.1",
*   title="Sistem Informasi Buku PPW2 API documentation",
*   termsOfService="http://swagger.io/terms/",
*   @OA\Contact (
*       email="muhammadirfanvalerian@mail.ugm.ac.id"
*   ),
*   @OA\License (
*       name="Apache 2.0",
*       url="http://www.apache.org/licenses/LICENSE-2.0.html"
*   )
* )
*/

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
            if(File::exists($photo) && ($post->picture != "noimage.png")){
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

    /**
        *
        * @OA\Get(
        *   path="/api/gallery",
        *   tags={"gallery"},
        *   summary="Returns a Collection of Gallery Posts",
        *   description="An endpoint to fetch gallery posts",
        *   operationId="getGallery",
        *   @OA\Response(
        *       response=200,
        *       description="successful operation",
        *       @OA\JsonContent(
        *           example={
        *               {
        *                   "id": 11,
        *                   "title": "testtt",
        *                   "description": "halo",
        *                   "picture": "673dc5cad11b01732101578.png",
        *                   "created_at": "2024-11-20T11:19:01.000000Z",
        *                   "updated_at": "2024-11-20T11:19:38.000000Z"
        *               }
        *           }
        *       )
        *   )
        * )
    */

    public function getGallery(){
        $gallery = Post::where('picture', '!=', '')->whereNotNull('picture')->orderBy('created_at', 'desc')->get();
        return response()->json($gallery);
    }
}
