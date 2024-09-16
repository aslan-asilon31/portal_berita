<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\News;
use App\Models\MasterCatPost;
use App\Models\MasterTypePost;
use App\Models\Settings;
use Illuminate\Session\TokenMismatchException;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;

class WelcomeDetailController extends Controller
{
    public function index()
    {
        $logo = Settings::where('category','logo')->first();

        $agenda = News::where('category', 'agenda')
            ->orderBy('created_at', 'desc')
            ->get();

        $pengumuman = News::with('masterCatPost')
            ->where('category', 'pengumuman')
            ->orderBy('created_at', 'desc')
            ->get();

        $kegiatan =  News::with('masterTypePost')
            ->where('category', 'kegiatan')
            ->where('status',1)
            ->orderBy('created_at', 'desc')
            ->get();

        $berita = News::where('category', 'berita')
            ->where('status',1)
            ->orderBy('created_at', 'desc')
            ->get();

        $infografis = News::where('category', 'infografis')
            ->where('status',1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('logo','infografis','berita','kegiatan','agenda','pengumuman'));
    }

    public function agenda()
    {
        $logo = Settings::where('category','logo')->first();

        $kegiatan =  News::where('category', 'kegiatan')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->latest()->paginate(5);

        $agenda = News::where('category', 'agenda')
                ->with('masterCatPost')
                ->where('status',1)
                ->orderBy('created_at', 'desc')
                ->latest()->paginate(5);
        return view('agenda', compact('logo','agenda','kegiatan'));
    }

    public function berita(){
        $logo = Settings::where('category','logo')->first();

        $berita = News::where('category', 'berita')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->get();
        return view('berita',compact('logo','berita'));
    }

    public function publikasi(){
        $logo = Settings::where('category','logo')->first();

        $kegiatan =  News::where('category', 'kegiatan')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->latest()->paginate(5);

        $publikasi = News::where('category', 'file-publikasi')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->latest()->paginate(5);
        return view('publikasi',compact('logo','publikasi','kegiatan'));
    }
    

    public function kegiatan(){
        $logo = Settings::where('category','logo')->first();

        $kegiatan =  News::where('category', 'kegiatan')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('kegiatan',compact('logo','kegiatan'));
    }

    public function kegiatan_detail($id, $type){
        $logo = Settings::where('category','logo')->first();

        $logo = Settings::where('category','logo')->first();

        $agenda = News::where('category', 'agenda')
            ->orderBy('created_at', 'desc')
            ->get();
        $logo = Settings::where('category','logo')->first();

        $pengumuman = News::with('masterCatPost')
            ->where('category', 'pengumuman')
            ->orderBy('created_at', 'desc')
            ->get();

        $kegiatan =  News::with('masterTypePost')
            ->where('category', 'kegiatan')
            ->where('id',$id)
            ->where('status',1)
            ->orderBy('created_at', 'desc')
            ->get();

        $berita = News::where('category', 'berita')
            ->where('status',1)
            ->orderBy('created_at', 'desc')
            ->get();

        $infografis = News::where('category', 'infografis')
            ->where('status',1)
            ->orderBy('created_at', 'desc')
            ->get();


        return view('kegiatan_detail',compact('logo','kegiatan'));
    }

    public function pengumuman(){
        $logo = Settings::where('category','logo')->first();

        $pengumuman = News::with('masterCatPost')
        ->where('category', 'pengumuman')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('pengumuman',compact('logo','pengumuman'));
    }

    
    public function tujuan(){
        $logo = Settings::where('category','logo')->first();

        return view('logo','tujuan');
    }
        
    public function visi_misi(){
        $logo = Settings::where('category','logo')->first();

        return view('logo','visi_misi');
    }
        
    public function tentang_kami(){
        $logo = Settings::where('category','logo')->first();

        return view('logo','tentang_kami');
    }
        
    public function galeri_foto(){
        $logo = Settings::where('category','logo')->first();

        return view('logo','galeri_foto');
    }
        
    public function infografis(){
        $logo = Settings::where('category','logo')->first();

        return view('logo','infografis');
    }
        
    public function kontak(){
        $logo = Settings::where('category','logo')->first();

        return view('logo','kontak');
    }
        
    public function galeri_video(){
        $logo = Settings::where('category','logo')->first();

        return view('logo','galeri_video');
    }
        
    public function susunan_redaksi(){
        $logo = Settings::where('category','logo')->first();

        $usersGroupedByTitle = User::select('id','title', 'sequence', 'name', 'image')
        ->orderBy('title')
        ->whereNot('jabatan', 'admin')
        ->orderBy('sequence')
        ->get()
        ->groupBy('title');

        // Mengubah data menjadi format yang bisa digunakan di frontend
        $nodes = [];
        $data = [];

        // Tambahkan node untuk "PIMPINAN-UMUM"
        $nodes[] = [
        'id' => 1,
        'title' => 'PIMPINAN-UMUM',
        'name' => 'SURATNO, S.Kom',
        ];

        // Iterasi melalui data yang dikelompokkan
        foreach ($usersGroupedByTitle as $title => $users) {
        if ($title !== 'PIMPINAN-UMUM') {
            $cleanTitle = str_replace('-', ' ', $title);

            // Menambahkan node untuk title
            $nodes[] = [
                'id' => $cleanTitle,
                'title' => $cleanTitle,
                'name' => $cleanTitle,
            ];

            // Hubungkan PIMPINAN-UMUM dengan title
            $data[] = ['PIMPINAN-UMUM', $cleanTitle];

            foreach ($users as $user) {
                $nodes[] = [
                    'id' => $user->name,
                    'title' => $user->sequence,
                    'name' => $user->name,
                    'image' => asset('storage/users/' . $user->image),
                ];

                // Menghubungkan title dengan nama
                $data[] = [$cleanTitle, $user->name];
            }
        }
        }

    
    

        return view('susunan_redaksi', compact('logo','usersGroupedByTitle','nodes', 'data'));
    }
    
    public function create(){
        $logo = Settings::where('category','logo')->first();

        $kategori = MasterCatPost::whereIn('id',['1','2','8','9']);
        return view('admin_agenda_form', compact('logo','kategori'));
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
        $image = $request->file('image');
        $image->storeAs('public/informasi_agenda', $image->hashName());

        // Ambil nilai reservationtime
        $reservationTime = $request->input('reservationtime');
        
        // Pisahkan string berdasarkan tanda "-"
        list($startTime, $endTime) = explode(' - ', $reservationTime);
        
        // Format tanggal dan waktu
        // Ubah format tanggal dan waktu sesuai dengan format yang dibutuhkan
        $startDateTime = \DateTime::createFromFormat('m/d/Y h:i A', trim($startTime))->format('Y-m-d H:i:s');
        $endDateTime = \DateTime::createFromFormat('m/d/Y h:i A', trim($endTime))->format('Y-m-d H:i:s');
        
        $news = News::create([
            'image'     => $image->hashName(),
            'name'     => $request->agenda_name,
            'status'   => $request->agenda_status,
            'start_date'   => $request->startDateTime,
            'end_date'   => $request->endDateTime,
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
        $logo = Settings::where('category','logo')->first();

        $news = News::find($id);
        if (!$news) {
            abort(404, 'News not found.');
        }

            
        return view('admin_agenda_form_edit', compact('logo','news'));
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
                'start_date'   => $request->startDateTime,
                'end_date'   => $request->endDateTime,
                'category'   => 'agenda'
            ]);

        } else {

            //hapus old image
            Storage::disk('local')->delete('public/informasi_agenda/'.$news->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/informasi_agenda', $image->hashName());

            $news->update([
                'image'     => $image->hashName(),
                'name'     => $request->agenda_name,
                'status'   => $request->agenda_status,
                'start_date'   => $request->startDateTime,
                'end_date'   => $request->endDateTime,
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
        Storage::disk('local')->delete('public/blogs/'.$news->image);
        $news->delete();

        if($news){
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-agenda.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-agenda.index');
        }
    }
}
