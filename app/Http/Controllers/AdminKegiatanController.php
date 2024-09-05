<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Status;
use App\Models\Theme;
use App\Models\MasterTypePost;
use App\Models\MasterCatPost;
use Illuminate\Session\TokenMismatchException;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\Settings;
use Illuminate\Support\Facades\Storage;

class AdminKegiatanController extends Controller
{
    public function index()
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $kegiatan =  News::where('category', 'kegiatan')
                    ->with('masterCatPost')
                    ->with('masterTypePost')
                    ->orderBy('created_at', 'desc')
                    ->get();


        return view('admin_kegiatan', compact('theme','logo','kegiatan'));
    }

    public function create()
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $kegiatan =  News::where('category', 'kegiatan')
                ->with('masterCatPost')
                ->orderBy('created_at', 'desc')
                ->get();
        $type_kegiatan = MasterTypePost::where('tipe','kegiatan')->get();

        return view('admin_kegiatan_form', compact('theme','logo','type_kegiatan','kegiatan'));
    }

    
    // public function create(){
    //     $kategori = MasterCatPost::whereIn('id',['1','2','8','9']);
    //     return view('admin_kegiatan_form', compact('kategori'));
    // }

    public function store(Request $request)
    {
        // dd($request);
        $request->validate([
            'kegiatan_type' => 'nullable',
            'kegiatan_name' => 'nullable',
            'kegiatan_detail' => 'nullable',
            'kegiatan_status' => 'nullable',
            'reservationtime' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        //upload image
        $image = $request->file('image');
        $image->storeAs('public/informasi__kegiatan', $image->hashName());

        $news = News::create([
            'type_news_id'     => $request->kegiatan_type,
            'cat_post_id'     => $request->kegiatan_status,
            'image'     => $image->hashName(),
            'name'     => $request->kegiatan_name,
            'desc2'     => $request->kegiatan_detail,
            'status'   => $request->kegiatan_status,
            'start_date'   => $request->start_date,
            'end_date'   => $request->end_date,
            'category'   => 'kegiatan'
        ]);

        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-kegiatan.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-kegiatan.index');
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

        $type_kegiatan = MasterTypePost::where('tipe','kegiatan')->get();
            
        return view('admin_kegiatan_form_edit', compact('type_kegiatan','theme','logo','news'));
    }

    public function update(Request $request, $id)
    {   
     
        $news = News::find($id);

        // Pastikan data ditemukan
        if (!$news) {
            return redirect()->back()->withErrors(['msg' => 'Data berita tidak ditemukan.']);
        }

            $kegiatan_names = $request->kegiatan_name; // Ambil nilai dari request
            $cleaned_kegiatan_name = preg_replace('/<\/?p>|<br\s*\/?>/', '', $kegiatan_names);

        if($request->file('image') == "") {

            $news->update([
                'type_news_id'  => $request->kegiatan_type,
                'name'     => $cleaned_kegiatan_name,
                'status'   => $request->kegiatan_status,
                'desc2'   => $request->kegiatan_detail,
                'start_date'   => $request->start_date,
                'end_date'   => $request->end_date,
                'category'   => 'kegiatan'
            ]);

        } else {

            //hapus old image
            Storage::disk('local')->delete('public/informasi__kegiatan/'.$news->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/informasi__kegiatan', $image->hashName());

            $news->update([
                'type_news_id'     => $request->kegiatan_type,
                'image'     => $image->hashName(),
                'name'     => $request->kegiatan_name,
                'status'   => $request->kegiatan_status,
                'desc2'   => $request->kegiatan_detail,
                'start_date'   => $request->start_date,
                'end_date'   => $request->end_date,
                'category'   => 'kegiatan'
            ]);

        }

        
        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-kegiatan.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-kegiatan.index');
        }

        
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        Storage::disk('local')->delete('public/informasi__kegiatan/'.$news->image);
        $news->delete();

        if($news){
            Alert::success('Sukses', 'Data Berhasil Dihapus!');
            return redirect()->route('admin-kegiatan.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Dihapus!');
            return redirect()->route('admin-kegiatan.index');
        }
    }
}
