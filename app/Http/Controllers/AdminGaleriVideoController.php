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

class AdminGaleriVideoController extends Controller
{
    public function index()
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $galeri_video = News::where('category', 'galeri-video')
                ->with('masterCatPost')
                ->orderBy('created_at', 'desc')
                ->get();

        return view('admin_galeri_video', compact('theme','logo','galeri_video'));
    }
    
    public function create(){
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $kategori = MasterCatPost::whereIn('id',['1','2','8','9']);
        return view('admin_galeri_video_form', compact('theme','logo','kategori'));
    }

    public function store(Request $request)
    {
        $logo = Settings::where('category','logo')->first();

        $request->validate([
            'video_name' => 'nullable',
            'video_status' => 'nullable',
            'video_link' => 'nullable',
        ]);

      
        $news = News::create([
            'name'     => $request->video_name,
            'status'   => $request->video_status,
            'video'   => $request->video_link,
            'category'   => 'galeri-video'
        ]);

        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-galeri-video.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-galeri-video.index');
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

            
        return view('admin_galeri_video_form_edit', compact('theme','logo','news'));
    }

    public function update(Request $request, News $news)
    {   

        // Cari data berdasarkan ID
        $news = News::find($id);

        // Pastikan data ditemukan
        if (!$news) {
            return redirect()->back()->withErrors(['msg' => 'Data berita tidak ditemukan.']);
        }


        $news->update([
            'name'     => $request->video_name,
            'status'   => $request->video_status,
            'video'   => $request->video_link,
            'category'   => 'galeri-video'
        ]);

       

        
        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-galeri-video.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-galeri-video.index');
        }

        
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        if($news){
            Alert::success('Sukses', 'Data Berhasil Dihapus!');
            return redirect()->route('admin-galeri-video.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Dihapus!');
            return redirect()->route('admin-galeri-video.index');
        }
    }
}
