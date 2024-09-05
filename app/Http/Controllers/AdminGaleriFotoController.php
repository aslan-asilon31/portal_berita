<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Theme;
use App\Models\MasterCatPost;
use App\Models\MasterTypePost;
use Illuminate\Session\TokenMismatchException;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\Settings;
use Illuminate\Support\Facades\Storage;


class AdminGaleriFotoController extends Controller
{
    public function index()
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $galeri_fotos = News::where('category', 'galeri-foto')
        ->with('masterCatPost')
                ->orderBy('created_at', 'desc')
                ->get();

        return view('admin_galeri_foto', compact('theme','logo','galeri_fotos'));
    }
    
    public function create(){
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $kategori = MasterCatPost::whereIn('id',['1','2','8','9']);
        return view('admin_galeri_foto_form', compact('theme','logo','kategori'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'foto_name' => 'nullable',
            'foto_status' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/galeri__foto', $image->hashName());

     
        $news = News::create([
            'image'     => $image->hashName(),
            'name'     => $request->foto_name,
            'status'   => $request->foto_status,
            'cat_post_id'   => $request->foto_status,
            'category'   => 'galeri-foto'
        ]);

        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-galeri-foto.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-galeri-foto.index');
        }

    }

    public function edit($id)
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $news = News::find($id);
        if (!$news) {
            abort(404, 'News not found.');
        }

            
        return view('admin_galeri_foto_form_edit', compact('theme','logo','news'));
    }

    public function update(Request $request, News $news)
    {   
        //get data  by ID
        $news = News::findOrFail($request->id);

            $foto_names = $request->foto_name; // Ambil nilai dari request
            $cleaned_foto_name = preg_replace('/<\/?p>|<br\s*\/?>/', '', $foto_names);

        if($request->file('image') == "") {

            $news->update([
                'name'     => $cleaned_foto_name,
                'status'   => $request->foto_status,
                'cat_post_id'   => $request->foto_status,
                'category'   => 'galeri-foto'
            ]);

        } else {

            //hapus old image
            Storage::disk('local')->delete('public/galeri__foto/'.$news->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/galeri__foto', $image->hashName());

            $news->update([
                'image'     => $image->hashName(),
                'name'     => $request->foto_name,
                'status'   => $request->foto_status,
                'cat_post_id'   => $request->foto_status,
                'category'   => 'galeri-foto'
            ]);

        }

        
        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-galeri-foto.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-galeri-foto.index');
        }

        
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        Storage::disk('local')->delete('public/galeri__foto/'.$news->image);
        $news->delete();

        if($news){
            Alert::success('Sukses', 'Data Berhasil Dihapus!');
            return redirect()->route('admin-galeri-foto.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Dihapus!');
            return redirect()->route('admin-galeri-foto.index');
        }
    }
}
