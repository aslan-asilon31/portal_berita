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
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

class AdminPengumumanController extends Controller
{
    public function index()
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $pengumuman = News::with('masterCatPost')
                    ->with('masterCatPost')
                    ->where('category', 'pengumuman')
                    ->orderBy('created_at', 'desc')
                    ->get();
                    

        return view('admin_pengumuman',compact('theme','logo','pengumuman'));
    }

    
    public function create(){
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $kategori = MasterCatPost::where('type','kegiatan');

        return view('admin_pengumuman_form', compact('theme','logo','kategori'));
    }

    public function store(Request $request)
    {

            // Jika ada gambar yang diunggah
            if ($request->hasFile('image')) {
               
                        
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
                    $destinationPath = public_path('PORTAL-BERITA-ASSET/informasi__pengumuman');
            
                    // Pastikan folder tujuan ada
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }
            
                    // Simpan file ke folder 'public/galeri__foto'
                    file_put_contents($destinationPath . '/' . $imageName, $imageBinary);
            
                    // Mengembalikan URL untuk akses gambar
                    $fileUrl = url('PORTAL-BERITA-ASSET/informasi__pengumuman/' . $imageName);
                } else {
                    // Jika gambar tidak ada
                    $fileUrl = null;
                }
 
            }
            
        
            // Buat array untuk data yang akan disimpan
            $data = [
                'name' => $request->input('pengumuman_name'),
                'image' => $imageName ?? null,
                'desc2' => $request->input('pengumuman_detail'),
                'cat_post_id' => $request->input('pengumuman_status'),
                'status' => $request->input('pengumuman_status'),
                'start_date'   => $request->start_date,
                'end_date'   => $request->end_date,
                'category' => 'pengumuman',
            ];


            // Simpan data ke database
            $news = News::create($data);
            

        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-pengumuman.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-pengumuman.index');
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

            
        return view('admin_pengumuman_form_edit', compact('theme','logo','news'));
    }

    public function update(Request $request, $id)
    {   
        
        $news = News::find($id);

        // Pastikan data ditemukan
        if (!$news) {
            return redirect()->back()->withErrors(['msg' => 'Data berita tidak ditemukan.']);
        }

        if($request->file('image') == "") {

            $news->update([
                'name'     => $request->pengumuman_name,
                'desc2'     => $request->pengumuman_detail,
                'cat_post_id' => $request->pengumuman_status,
                'status'   => $request->pengumuman_status,
                'start_date'   => $request->start_date,
                'end_date'   => $request->end_date,
                'category'   => 'pengumuman'
            ]);

        } else {
            // Hapus gambar lama
            if ($news->image && File::exists(public_path('PORTAL-BERITA-ASSET/informasi__pengumuman/' . $news->image))) {
                File::delete(public_path('PORTAL-BERITA-ASSET/informasi__pengumuman/' . $news->image));
            }
    
            // Upload gambar baru
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension(); // Membuat nama file unik
            $destinationPath = public_path('PORTAL-BERITA-ASSET/informasi__pengumuman');
            
            // Pastikan folder tujuan ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
    
            // Simpan file ke folder 'public/users'
            $file->move($destinationPath, $fileName);
    
            // Set nama file baru
            $news->image = $fileName;

            $news->update([
                'image'     =>  $news->image,
                'name'     => $request->pengumuman_name,
                'cat_post_id' => $request->pengumuman_status,
                'status'   => $request->pengumuman_status,
                'start_date'   => $request->start_date,
                'end_date'   => $request->end_date,
                'category'   => 'pengumuman'
            ]);

        }

        
        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-pengumuman.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-pengumuman.index');
        }

        
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        Storage::disk('local')->delete('public/informasi__pengumuman/'.$news->image);
        $news->delete();

        if($news){
            Alert::success('Sukses', 'Data Berhasil Dihapus!');
            return redirect()->route('admin-pengumuman.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Dihapus!');
            return redirect()->route('admin-pengumuman.index');
        }
    }
}
