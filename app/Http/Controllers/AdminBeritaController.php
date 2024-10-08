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
use Illuminate\Support\Facades\File;


class AdminBeritaController extends Controller
{
    public function index()
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $berita = News::where('category', 'berita')
                ->with('masterCatPost')
                ->orderBy('created_at', 'desc')
                ->get();
        return view('admin_berita', compact('theme','logo','berita'));
    }
    
    public function create(){
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $kategori = MasterCatPost::whereIn('id',['1','2','8','9']);

        $type_berita = MasterTypePost::where('tipe','berita')->get();
        return view('admin_berita_form', compact('type_berita','theme','logo','kategori'));
    }

    public function store(Request $request)
    {
        
        // Ambil data gambar cropped dari request
        $imageData = $request->input('image_cropped');
        
        if ($imageData) {
            // Menghapus prefix data URL base64
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = str_replace(' ', '+', $imageData);
            $imageName = time() . '.png'; // Nama file gambar yang disimpan
    
            // Decode base64 menjadi binary
            $imageBinary = base64_decode($imageData);
    
            // Tentukan lokasi tujuan di dalam folder 'public'
            $destinationPath = public_path('PORTAL-BERITA-ASSET/informasi__berita');
    
            // Pastikan folder tujuan ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
    
            // Simpan file ke folder 'public/galeri__foto'
            file_put_contents($destinationPath . '/' . $imageName, $imageBinary);
    
            // Mengembalikan URL untuk akses gambar
            $fileUrl = url('PORTAL-BERITA-ASSET/informasi__berita/' . $imageName);
        } else {
            // Jika gambar tidak ada
            $fileUrl = null;
        }


        // Ambil nilai reservationtime
        $news = News::create([
            'cat_post_id'   => $request->berita_status,
            'image'     => $imageName ?? null,
            'name'     => $request->berita_name,
            'desc2'   => $request->berita_detail,
            'berita_type'   => $request->type_news_id,
            'status'   => $request->berita_status,
            'start_date'   => $request->start_date,
            'end_date'   => $request->end_date,
            'category'   => 'berita'
        ]);

        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-berita.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-berita.index');
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

        $kategori = MasterTypePost::where('tipe','berita')->get();
        $type_kegiatan = MasterTypePost::where('tipe','berita')->get();

            
        return view('admin_berita_form_edit', compact('type_kegiatan','theme','kategori','logo','news'));
    }

    public function update(Request $request, $id)
    {   
        // Cari data berdasarkan ID
        $news = News::find($id);

        // Pastikan data ditemukan
        if (!$news) {
            return redirect()->back()->withErrors(['msg' => 'Data berita tidak ditemukan.']);
        }

        if($request->file('image') == "") {

            $news->update([
                'name'     => $request->berita_name,
                'cat_post_id'   => $request->berita_status,
                'status'   => $request->berita_status,
                'desc2'   => $request->berita_detail,
                'type_news_id'   => $request->berita_type,
                'start_date'   => $request->start_date,
                'end_date'   => $request->end_date,
                'category'   => 'berita'
            ]);

            if($news){
                //redirect dengan pesan sukses
                Alert::success('Sukses', 'Data Berhasil Disimpan!');
                return redirect()->route('admin-berita.index');
            }else{
                //redirect dengan pesan error
                Alert::warning('Error', 'Data Gagal Disimpan!');
                return redirect()->route('admin-berita.index');
            }


        } else {



            // Ambil data gambar cropped dari request
            $imageData = $request->input('image_cropped');


            
            if ($imageData) {
                // Menghapus prefix data URL base64
                $imageData = str_replace('data:image/png;base64,', '', $imageData);
                $imageData = str_replace(' ', '+', $imageData);
                $imageName = time() . '.png'; // Nama file gambar yang disimpan
        
                // Decode base64 menjadi binary
                $imageBinary = base64_decode($imageData);
        
                // Tentukan lokasi tujuan di dalam folder 'public'
                $destinationPath = public_path('PORTAL-BERITA-ASSET/informasi__berita');
        
                // Pastikan folder tujuan ada
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
        
                // Simpan file ke folder 'public/galeri__foto'
                file_put_contents($destinationPath . '/' . $imageName, $imageBinary);
        
                // Mengembalikan URL untuk akses gambar
                $fileUrl = url('PORTAL-BERITA-ASSET/informasi__berita/' . $imageName);
            } else {
                // Jika gambar tidak ada
                $fileUrl = null;
            }

            
            $news->update([
                'image'     =>  $imageName ?? null,
                'cat_post_id'   => $request->berita_status,
                'name'     => $request->berita_name,
                'status'   => $request->berita_status,
                'type_news_id'   => $request->berita_type,
                'desc2'   => $request->berita_detail,
                'start_date'   => $request->start_date,
                'end_date'   => $request->end_date,
                'category'   => 'berita'
            ]);

            if($news){
                //redirect dengan pesan sukses
                Alert::success('Sukses', 'Data Berhasil Disimpan!');
                return redirect()->route('admin-berita.index');
            }else{
                //redirect dengan pesan error
                Alert::warning('Error', 'Data Gagal Disimpan!');
                return redirect()->route('admin-berita.index');
            }

        }

        
        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-berita.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-berita.index');
        }

        
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        // Tentukan path file yang akan dihapus
        $filePath = public_path('PORTAL-BERITA-ASSET/informasi__kegiatan/' . $news->image);

        // Hapus file jika ada
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $news->delete();

        if($news){
            Alert::success('Sukses', 'Data Berhasil Dihapus!');
            return redirect()->route('admin-berita.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Dihapus!');
            return redirect()->route('admin-berita.index');
        }
    }
}
