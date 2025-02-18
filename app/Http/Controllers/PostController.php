<?php
   
namespace App\Http\Controllers;
    
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
   
class PostController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    //index() Ini adalah metode yang digunakan untuk menampilkan daftar semua post. Dalam metode ini:
//[-] Post::all() digunakan untuk mengambil semua data post dari basis data.
//[-] Inertia::render('Posts/Index', ['posts' => $posts]) digunakan untuk menampilkan 
//tampilan dengan menggunakan framework Inertia. Framework Inertia adalah salah satu cara 
//untuk mengintegrasikan aplikasi Laravel dengan front-end JavaScript dalm hal ini kita menggunakan react

    public function index()
    {
        $posts = Post::all();
        return Inertia::render('Posts/Index', ['posts' => $posts]);
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    //create(): Ini adalah metode yang digunakan untuk menampilkan 
    //formulir pembuatan post baru. Metode ini hanya merender tampilan 'Posts/Create'.

    public function create()
    {
        return Inertia::render('Posts/Create');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    //Ini adalah metode yang digunakan untuk menyimpan post baru ke basis data. 
    // Dalam metode ini:[-] $request adalah objek yang digunakan untuk mengambil data 
    // yang dikirim melalui permintaan HTTP, seperti data dari formulir.
    // [-] validate() digunakan untuk memvalidasi data yang diterima dari formulir. 
    // Dalam contoh ini, validasi dilakukan untuk memastikan bahwa 'title' wajib diisi dan 'body' wajib diisi.
    // [-] Jika validasi berhasil, post baru dibuat menggunakan Post::create($validated), 
    // di mana $validated adalah data yang sudah divalidasi.
    // [-] Kemudian, pengguna akan diarahkan kembali ke halaman daftar post dengan pesan sukses Post created.

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
        ])->validate();
   
        Post::create($request->all());
            
        return redirect(route('posts.index'))->with('success', 'Post created.');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    //Ini adalah metode yang digunakan untuk memperbarui post yang sudah ada. Dalam metode ini:
//[-] $request digunakan untuk memvalidasi data yang dikirim dari formulir pengeditan.
//[-] validate() digunakan untuk memastikan bahwa 'title' 
//harus diisi dan memiliki maksimal 50 karakter, dan 'body' wajib diisi.
//[-] Setelah validasi berhasil, post yang sesuai dengan Post $post diperbarui dengan 
//data yang sudah divalidasi menggunakan $post->update($validated).
//[-] Pengguna diarahkan kembali ke halaman daftar post dengan pesan sukses Post updated.
    public function edit(Post $post)
    {
        return Inertia::render('Posts/Edit', [
            'post' => $post
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        Validator::make($request->all(), [
            'title' => ['required'],
            'body' => ['required'],
        ])->validate();
    
        Post::find($id)->update($request->all());
        return redirect(route('posts.index'))->with('success', 'Post updated.');
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function destroy($id)
    {
        Post::find($id)->delete();
        return redirect(route('posts.index'))->with('success', 'Post deleted.');
    }
}  
