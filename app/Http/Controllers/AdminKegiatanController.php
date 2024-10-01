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
use Illuminate\Support\Facades\File;

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
            $destinationPath = public_path('PORTAL-BERITA-ASSET/informasi__kegiatan');
    
            // Pastikan folder tujuan ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
    
            // Simpan file ke folder 'public/galeri__foto'
            file_put_contents($destinationPath . '/' . $imageName, $imageBinary);
    
            // Mengembalikan URL untuk akses gambar
            $fileUrl = url('PORTAL-BERITA-ASSET/informasi__kegiatan/' . $imageName);
        } else {
            // Jika gambar tidak ada
            $fileUrl = null;
        }



        $news = News::create([
            'type_news_id'     => $request->kegiatan_type,
            'cat_post_id'     => $request->kegiatan_status,
            'image'     => $imageName ?? null,
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
                'name'     => $request->kegiatan_name,
                'status'   => $request->kegiatan_status,
                'desc2'   => $request->kegiatan_detail,
                'start_date'   => $request->start_date,
                'end_date'   => $request->end_date,
                'category'   => 'kegiatan'
            ]);

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
                $destinationPath = public_path('PORTAL-BERITA-ASSET/informasi__kegiatan');
        
                // Pastikan folder tujuan ada
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }
        
                // Simpan file ke folder 'public/galeri__foto'
                file_put_contents($destinationPath . '/' . $imageName, $imageBinary);
        
                // Mengembalikan URL untuk akses gambar
                $fileUrl = url('PORTAL-BERITA-ASSET/informasi__kegiatan/' . $imageName);
            } else {
                // Jika gambar tidak ada
                $fileUrl = null;
            }


            $news->update([
                'type_news_id'     => $request->kegiatan_type,
                'image'     => $imageName ?? null,
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
            
        // Tentukan path file yang akan dihapus
        $filePath = public_path('PORTAL-BERITA-ASSET/informasi__kegiatan/' . $news->image);

        // Hapus file jika ada
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

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
