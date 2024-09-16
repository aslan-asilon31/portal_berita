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
            'image_cropped' => 'nullable', // Validasi base64 tanpa tipe image
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
            $destinationPath = public_path('PORTAL-BERITA-ASSET/galeri__foto');
    
            // Pastikan folder tujuan ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
    
            // Simpan file ke folder 'public/galeri__foto'
            file_put_contents($destinationPath . '/' . $imageName, $imageBinary);
    
            // Mengembalikan URL untuk akses gambar
            $fileUrl = url('PORTAL-BERITA-ASSET/galeri__foto/' . $imageName);
        } else {
            // Jika gambar tidak ada
            $fileUrl = null;
        }
    
        $news = News::create([
            'image'     => $imageName ?? null,
            'name'     => $request->foto_name,
            'status'   => $request->foto_status,
            'cat_post_id'   => $request->foto_status,
            'category'   => 'galeri-foto'
        ]);
    
        if ($news) {
            // Redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-galeri-foto.index');
        } else {
            // Redirect dengan pesan error
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


        if($request->file('image') == "") {

            $news->update([
                'name'     => $cleaned_foto_name,
                'status'   => $request->foto_status,
                'cat_post_id'   => $request->foto_status,
                'category'   => 'galeri-foto'
            ]);

        } else {


            //hapus old image
                $filePath = public_path('PORTAL-BERITA-ASSET/galeri__foto/' . $news->image_cropped);

                if (File::exists($filePath)) {
                    File::delete($filePath);
                }
            //hapus old image end

            //upload new image
               
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
                        $destinationPath = public_path('PORTAL-BERITA-ASSET/galeri__foto');
                
                        // Pastikan folder tujuan ada
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0755, true);
                        }
                
                        // Simpan file ke folder 'public/galeri__foto'
                        file_put_contents($destinationPath . '/' . $imageName, $imageBinary);
                
                        // Mengembalikan URL untuk akses gambar
                        $fileUrl = url('PORTAL-BERITA-ASSET/galeri__foto/' . $imageName);
                    } else {
                        // Jika gambar tidak ada
                        $fileUrl = null;
                    }
            //upload image end

            $news->update([
                'image'     => $imageName ?? null,
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
        // Tentukan path file yang akan dihapus
        $filePath = public_path('PORTAL-BERITA-ASSET/galeri__foto/' . $news->image);

        // Hapus file jika ada
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
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
