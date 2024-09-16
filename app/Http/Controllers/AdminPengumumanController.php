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
                //upload image
                    // Ambil file dari request
                    $file = $request->file('image');
                    $originalFileName = $file->getClientOriginalName();

                    // Tentukan lokasi tujuan di dalam folder 'public'
                    $destinationPath = public_path('PORTAL-BERITA-ASSET/informasi__pengumuman');

                    // Pastikan folder tujuan ada
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0755, true);
                    }

                    // Simpan file ke folder 'public/informasi__pengumuman'
                    $fileName = $file->getClientOriginalName();
                    $file->move($destinationPath, $fileName);

                    // Mengembalikan URL untuk akses gambar
                    $fileUrl = url('PORTAL-BERITA-ASSET/informasi__pengumuman/' . $fileName);
                //upload image end
 
            }
            
        
            // Buat array untuk data yang akan disimpan
            $data = [
                'name' => $request->input('pengumuman_name'),
                'image' => $originalFileName,
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

            $pengumuman_names = $request->pengumuman_name; // Ambil nilai dari request
            $cleaned_pengumuman_name = preg_replace('/<\/?p>|<br\s*\/?>/', '', $pengumuman_names);

        if($request->file('image') == "") {

            $news->update([
                'name'     => $cleaned_pengumuman_name,
                'desc2'     => $pengumuman_detail,
                'cat_post_id' => $request->pengumuman_status,
                'status'   => $request->pengumuman_status,
                'start_date'   => $request->startDateTime,
                'end_date'   => $request->endDateTime,
                'category'   => 'pengumuman'
            ]);

        } else {

            //hapus old image
            Storage::disk('local')->delete('public/informasi__pengumuman/'.$news->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/informasi__pengumuman', $image->hashName());

            $news->update([
                'image'     => $image->hashName(),
                'name'     => $request->pengumuman_name,
                'cat_post_id' => $request->pengumuman_status,
                'status'   => $request->pengumuman_status,
                'start_date'   => $request->startDateTime,
                'end_date'   => $request->endDateTime,
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
