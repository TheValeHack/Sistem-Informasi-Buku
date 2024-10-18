<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::all();
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
        $buku = new Book();
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
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
        $buku = Book::find($id);
        $buku->judul = $request->judul;
        $buku->penulis = $request->penulis;
        $buku->harga = $request->harga;
        $buku->tgl_terbit = $request->tgl_terbit;
        $buku->save();
        
        return redirect("/books");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = Book::find($id);
        $buku->delete();
        return redirect("/books");
    }
}
