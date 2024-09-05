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

class AdminPublikasiController extends Controller
{
    public function index()
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $publikasi = News::where('category', 'publikasi')
                ->with('masterCatPost')
                ->orderBy('created_at', 'desc')
                ->get();

        return view('admin_publikasi', compact('theme','logo','publikasi'));
    }

    
    public function create(){
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $kategori = MasterCatPost::whereIn('id',['1','2','8','9']);
        return view('admin_publikasi_form', compact('theme','logo','kategori'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:20480', // Maksimum ukuran 20MB
            'publikasi_name' => 'required|string',
            'publikasi_status' => 'required|string'
        ]);

        $publikasi_name = strip_tags($request->publikasi_name);
        // Unggah file
        $pdf_file = $request->file('pdf_file');
        $pdf_path = $pdf_file->storeAs('public/file-publikasi', $pdf_file->hashName());
    
        // Simpan informasi ke database
        $news = News::create([
            'file' => $pdf_file->hashName(),
            'name' => $publikasi_name,
            'status' => $request->publikasi_status,
            'category' => 'file-publikasi'
        ]);

        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-publikasi.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-publikasi.index');
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

            
        return view('admin_publikasi_form_edit', compact('theme','logo','news'));
    }

    public function update(Request $request, News $news)
    {   
        //get data  by ID
        $news = News::findOrFail($request->id);


        
        $publikasi_name = strip_tags($request->publikasi_name);
        if($request->file('pdf_file') == "") {

            $news->update([
                'name'     => $publikasi_name,
                'status'   => $request->publikasi_status,
                'category'   => 'file-publikasi'
            ]);

        } else {

            //hapus old image
            Storage::disk('local')->delete('public/file-publikasi/'.$news->image);

            //upload new image
            $pdf_file = $request->file('pdf_file');
            $pdf_file->storeAs('public/file-publikasi', $pdf_file->hashName());

            $news->update([
                'file'     => $pdf_file->hashName(),
                'name'     => $request->publikasi_name,
                'status'   => $request->publikasi_status,
                'start_date'   => $request->startDateTime,
                'end_date'   => $request->endDateTime,
                'category'   => 'publikasi'
            ]);

        }

        
        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-publikasi.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-publikasi.index');
        }

        
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        Storage::disk('local')->delete('public/file-publikasi/'.$news->image);
        $news->delete();

        if($news){
            Alert::success('Sukses', 'Data Berhasil Dihapus!');
            return redirect()->route('admin-publikasi.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Dihapus!');
            return redirect()->route('admin-publikasi.index');
        }
    }
}
