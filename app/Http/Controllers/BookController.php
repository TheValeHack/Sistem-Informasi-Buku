<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Auth;
use Exception;
use File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all()->sortByDesc('id');
        if(Auth::check()){
            return view('book.index',compact("books"));
        }
        return redirect()->route('login')->withErrors([
            'email' => 'Please login to access the books.'
        ])->onlyInput('email');
    }
    public function create()
    {
        return view('book.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:250',
            'penulis' => 'required|string|max:250',
            'harga' => 'required|integer',
            'tgl_terbit' => 'required|date',
            'photo' => 'image|nullable|max:1999'
        ]);
        if($request->hasFile('photo')){
            $fileNameWithExt = $request->file('photo')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $request->file('photo')->getClientOriginalExtension();
            $fileNameSimpan = $fileName . "_". time() .  "." . $fileExt;
            $path = $request->file('photo')->storeAs('photos', $fileNameSimpan); 
        } else {
            $path = null;
        }
        $buku = new Book();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->photo = $path;
        $buku->save();
        
        return redirect("/books");
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    
    public function edit(string $id)
    {
        $book = Book::find($id);
        // dd($book);
        return view('book.edit',compact("book"));
        
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required|string|max:250',
            'penulis' => 'required|string|max:250',
            'harga' => 'required|integer',
            'tgl_terbit' => 'required|date',
            'photo' => 'image|nullable|max:1999'
        ]);
        $buku = Book::findOrFail($id);
        if($request->hasFile('photo')){
            $previousPhoto = public_path()."/storage/".$buku->photo;
            try {
                if(File::exists($previousPhoto)){
                    File::delete($previousPhoto);
                }
            } catch (Exception $e){
                
            }
            $fileNameWithExt = $request->file('photo')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $fileExt = $request->file('photo')->getClientOriginalExtension();
            $fileNameSimpan = $fileName . "_". time() .  "." . $fileExt;
            $path = $request->file('photo')->storeAs('photos', $fileNameSimpan); 
        } else {
            $path = null;
        }
        $buku = Book::find($id);
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        if($path){
            $buku->photo = $path;
        }
        $buku->save();
        
        return redirect("/books");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Book::find($id);
        $photo = public_path()."/storage/".$buku->photo;
        try {
            if(File::exists($photo)){
                File::delete($photo);
            }
        } catch (Exception $e){

        }
        $buku->delete();
        return redirect("/books");
    }
}
