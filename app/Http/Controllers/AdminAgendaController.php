<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\MasterCatPost;
use App\Models\MasterTypePost;
use Illuminate\Session\TokenMismatchException;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\Settings;
use App\Models\Theme;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AdminAgendaController extends Controller
{
    public function index()
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $agenda = News::where('category', 'agenda')
                ->with('masterCatPost')
                ->orderBy('created_at', 'desc')
                ->get();
        return view('admin_agenda', compact('theme','logo','agenda'));
    }

    public function create(){
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();
        $agenda = MasterCatPost::whereIn('id',['1','2','8','9']);
        return view('admin_agenda_form', compact('theme','logo','agenda'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'agenda_name' => 'nullable',
            'agenda_status' => 'nullable',
            'reservationtime' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        //upload image
            // Ambil file dari request
            $file = $request->file('image');
            $originalFileName = $file->getClientOriginalName();

            // Tentukan lokasi tujuan di dalam folder 'public'
            $destinationPath = public_path('PORTAL-BERITA-ASSET/informasi__agenda');

            // Pastikan folder tujuan ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // Simpan file ke folder 'public/informasi__agenda'
            $fileName = $file->getClientOriginalName();
            $file->move($destinationPath, $fileName);

            // Mengembalikan URL untuk akses gambar
            $fileUrl = url('PORTAL-BERITA-ASSET/informasi__agenda/' . $fileName);
        //upload image end

        
        $news = News::create([
            'image'     => $originalFileName,
            'name'     => $request->agenda_name,
            'event'     => $request->agenda_detail,
            'location'     => $request->agenda_location,
            'status'   => $request->agenda_status,
            'start_date'   => $request->start_date,
            'end_date'   => $request->end_date,
            'category'   => 'agenda'
        ]);

        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-agenda.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-agenda.index');
        }

    }

    public function edit($id)
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();
        $news = News::find($id);
        if (!$news) {
            abort(404, 'agenda not found.');
        }
        return view('admin_agenda_form_edit', compact('theme','logo','news'));
    }

    public function update(Request $request, News $news)
    { 
        
        //get data  by ID
        $news = News::findOrFail($request->id);

            $agenda_names = $request->agenda_name; // Ambil nilai dari request
            $cleaned_agenda_name = preg_replace('/<\/?p>|<br\s*\/?>/', '', $agenda_names);

        if($request->file('image') == "") {

            $news->update([
                'name'     => $cleaned_agenda_name,
                'status'   => $request->agenda_status,
                'start_date'   => $request->start_date,
                'end_date'   => $request->end_date,
                'updated_at'   => now(),
                'category'   => 'agenda'
            ]);

        } else {


            //hapus old image
            $filePath = public_path('PORTAL-BERITA-ASSET/informasi__agenda/' . $news->image);

            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            //hapus old image end

            //upload new image
                //upload image
                // Ambil file dari request
                $file = $request->file('image');
                $originalFileName = $file->getClientOriginalName();

                // Tentukan lokasi tujuan di dalam folder 'public'
                $destinationPath = public_path('PORTAL-BERITA-ASSET/informasi__agenda');

                // Pastikan folder tujuan ada
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Simpan file ke folder 'public/informasi__agenda'
                $fileName = $file->getClientOriginalName();
                $file->move($destinationPath, $fileName);

                // Mengembalikan URL untuk akses gambar
                $fileUrl = url('informasi__agenda/' . $fileName);
            //upload image end

            $news->update([
                'image'     => $originalFileName,
                'name'     => $request->agenda_name,
                'desc2'     => $request->agenda_detail,
                'status'   => $request->agenda_status,
                'start_date'   => $request->start_date,
                'end_date'   => $request->end_date,
                'updated_at'   => now(),
                'category'   => 'agenda'
            ]);

        }

        
        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-agenda.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-agenda.index');
        }

        
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        // Tentukan path file yang akan dihapus
        $filePath = public_path('PORTAL-BERITA-ASSET/informasi__agenda/' . $news->image);

        // Hapus file jika ada
        if (File::exists($filePath)) {
            File::delete($filePath);
        }
        $news->delete();

        if($news){
            Alert::success('Sukses', 'Data Berhasil Dihapus!');
            return redirect()->route('admin-agenda.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Dihapus!');
            return redirect()->route('admin-agenda.index');
        }
    }


}
