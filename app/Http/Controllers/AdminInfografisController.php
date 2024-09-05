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

class AdminInfografisController extends Controller
{
    public function index()
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $infografis = News::where('category', 'infografis')
        ->with('masterCatPost')
                ->orderBy('created_at', 'desc')
                ->get();

        return view('admin_infografis', compact('theme','logo','infografis'));
    }
    
    public function create(){
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $kategori = MasterCatPost::whereIn('id',['1','2','8','9']);
        return view('admin_infografis_form', compact('theme','logo','kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'infografis_name' => 'nullable',
            'infografis_status' => 'nullable',
            'reservationtime' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/informasi__infografis', $image->hashName());

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
            'name'     => $request->infografis_name,
            'status'   => $request->infografis_status,
            'start_date'   => $request->startDateTime,
            'end_date'   => $request->endDateTime,
            'category'   => 'infografis'
        ]);

        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-infografis.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-infografis.index');
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

            
        return view('admin_infografis_form_edit', compact('theme','logo','news'));
    }

    public function update(Request $request, News $news)
    {   
        //get data  by ID
        $news = News::findOrFail($request->id);

            $infografis_names = $request->infografis_name; // Ambil nilai dari request
            $cleaned_infografis_name = preg_replace('/<\/?p>|<br\s*\/?>/', '', $infografis_names);

        if($request->file('image') == "") {

            $news->update([
                'name'     => $cleaned_infografis_name,
                'status'   => $request->infografis_status,
                'start_date'   => $request->startDateTime,
                'end_date'   => $request->endDateTime,
                'category'   => 'infografis'
            ]);

        } else {

            //hapus old image
            Storage::disk('local')->delete('public/informasi__infografis/'.$news->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/informasi__infografis', $image->hashName());

            $news->update([
                'image'     => $image->hashName(),
                'name'     => $request->infografis_name,
                'status'   => $request->infografis_status,
                'start_date'   => $request->startDateTime,
                'end_date'   => $request->endDateTime,
                'category'   => 'infografis'
            ]);

        }

        
        if($news){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-infografis.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-infografis.index');
        }

        
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        Storage::disk('local')->delete('public/informasi__infografis/'.$news->image);
        $news->delete();

        if($news){
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-infografis.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-infografis.index');
        }
    }
}
