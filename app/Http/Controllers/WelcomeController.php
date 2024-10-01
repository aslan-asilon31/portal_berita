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

class WelcomeController extends Controller
{
    public function index()
    {
        $banner = Settings::where('category','banner')->first();

        $agenda = News::where('category', 'agenda')
            ->orderBy('created_at', 'desc')
            ->where('status',1)
            ->get();
        $logo = Settings::where('category','logo')->first();

        $pengumuman = News::with('masterCatPost')
            ->where('category', 'pengumuman')
            ->where('status',1)
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

        $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();

        $infografis = News::where('category', 'infografis')
            ->where('status',1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('social_medias','berita_kategori','logo','banner','social_medias','infografis','berita','kegiatan','agenda','pengumuman'));
    }

    public function agenda()
    {
        $social_medias = Settings::where('category','social-media')->get();

        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')->first();

        $kegiatan =  News::where('category', 'kegiatan')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $agenda = News::where('category', 'agenda')
                ->with('masterCatPost')
                ->where('status',1)
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        return view('agenda', compact('social_medias','berita_kategori','logo','agenda','kegiatan'));
    }

    public function berita(){
        $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')->first();

        $berita = News::where('category', 'berita')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('berita',compact('social_medias','berita_kategori','logo','berita'));
    }

    public function publikasi(){
        $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')->first();

        $kegiatan =  News::where('category', 'kegiatan')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        $publikasi = News::where('category', 'publikasi')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('publikasi',compact('social_medias','berita_kategori','logo','publikasi','kegiatan'));
    }
    

    public function kegiatan(){
                $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')->first();

        $kegiatan =  News::where('category', 'kegiatan')
            ->where('status',1)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('kegiatan',compact('social_medias','berita_kategori','logo','kegiatan'));
    }

    public function detail($id, $type){
         $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();

        $types = $type;
        $logo = Settings::where('category','logo')->first();

        $logo = Settings::where('category','logo')->first();

        $agenda = News::where('category', 'agenda')
            ->orderBy('created_at', 'desc')
            ->get();
        $logo = Settings::where('category','logo')->first();

        $kegiatan =  News::with('masterTypePost')
        ->where('category', 'kegiatan')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->get();




        $news =  News::with('masterTypePost')
            ->where('category', $types)
            ->where('id',$id)
            ->where('status',1)
            ->orderBy('created_at', 'desc')
            ->first();


        return view('detail',compact('social_medias','berita_kategori','logo','kegiatan','types','news'));
    }

    public function pengumuman(){
                $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')->first();

        $pengumuman = News::with('masterCatPost')
        ->where('category', 'pengumuman')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->get();
        return view('pengumuman',compact('social_medias','berita_kategori','logo','pengumuman'));
    }

    
    public function tujuan(){
        $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')->first();

        return view('tujuan',compact('social_medias','berita_kategori','logo'));
    }
        
    public function visi_misi(){
                $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')
        ->first();
        $visi_misi = Settings::where('category','visi-misi')->get();

        return view('visi_misi',compact('visi_misi','social_medias','berita_kategori','logo'));
    }
        
    public function tentang_kami(){
                $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')
        ->first();


        return view('tentang_kami',compact('social_medias','berita_kategori','logo'));
    }
        
    public function galeri_foto(){
        $galeri_foto = News::where('category', 'galeri-foto')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->get();

        $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')->first();

        return view('galeri_foto',compact('social_medias','berita_kategori','logo','galeri_foto'));
    }
        
    public function infografis(){
                $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')
        ->where('status',1)
        ->first();

        return view('infografis',compact('social_medias','berita_kategori','logo'));
    }
        
    public function kontak(){
        $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')
        ->first();

        return view('kontak',compact('social_medias','berita_kategori','logo'));
    }
        
    public function galeri_video(){
        $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')
        ->first();

        $galeri_video = News::where('category', 'galeri-video')
        ->where('status',1)
        ->orderBy('created_at', 'desc')
        ->get();

        return view('galeri_video',compact('social_medias','galeri_video','berita_kategori','logo'));
    }
        
    public function susunan_redaksi(){
                $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')->first();

        $usersGroupedByTitle = User::select('id', 'title', 'sequence', 'jabatan', 'name', 'image')
        ->whereNot('jabatan', 'admin')
        ->orderByRaw("title = 'PIMPINAN-PUSAT' DESC") 
        ->orderBy('sequence')
        ->get()
        ->groupBy('title');
        

        return view('susunan_redaksi', compact('social_medias','berita_kategori','logo','usersGroupedByTitle'));
    }
    
    public function create(){
                $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')->first();

        $kategori = MasterCatPost::whereIn('id',['1','2','8','9']);
        return view('admin_agenda_form', compact('social_medias','berita_kategori','kategori'));
    }

    public function store(Request $request)
    {
        $social_medias = Settings::where('category','social-media')->get();

        $berita_kategori = MasterTypePost::all();
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
                    $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
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
        $social_medias = Settings::where('category','social-media')->get();

        $berita_kategori = MasterTypePost::all();
        $logo = Settings::where('category','logo')->first();

        $news = News::find($id);
        if (!$news) {
            abort(404, 'News not found.');
        }

            
        return view('admin_agenda_form_edit', compact('social_medias','berita_kategori','news'));
    }

    public function update(Request $request, News $news)
    {
        $social_medias = Settings::where('category','social-media')->get();

        $berita_kategori = MasterTypePost::all();   
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
                    $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
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
        $social_medias = Settings::where('category','social-media')->get();

        $berita_kategori = MasterTypePost::all();
        $news = News::findOrFail($id);
        Storage::disk('local')->delete('public/blogs/'.$news->image);
        $news->delete();

        if($news){
                    $social_medias = Settings::where('category','social-media')->get();
        $berita_kategori = MasterTypePost::all();
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-agenda.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-agenda.index');
        }
    }
}
