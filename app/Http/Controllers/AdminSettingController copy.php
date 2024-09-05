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

class AdminSettingController extends Controller
{
    public function index()
    {
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();
        $visi_misi = Settings::where('category','visi-misi')->first();
        $banner = Settings::where('category','banner')->first();
        $social_medias = Settings::where('category','social-media')->get();
        $agenda = News::where('category', 'agenda')
                ->with('masterCatPost')
                ->orderBy('created_at', 'desc')
                ->get();
        return view('admin_setting', compact('visi_misi','theme','banner','logo','agenda','social_medias'));
    }

    public function create(){
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();
        $agenda = MasterCatPost::whereIn('id',['1','2','8','9']);
        return view('admin_agenda_form', compact('theme','logo','agenda'));
    }

    public function store(Request $request)
    {
   

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/informasi__agenda', $image->hashName());

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
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();
        $news = News::find($id);
        if (!$news) {
            abort(404, 'agenda not found.');
        }
        return view('admin_agenda_form_edit', compact('theme','logo','news'));
    }

    public function update(Request $request, $id)
    {   

        
        $settings = Settings::find($id);

        // Pastikan data ditemukan
        if (!$settings) {
            return redirect()->back()->withErrors(['msg' => 'Data tidak ditemukan.']);
        }

        
        if($request->kategori_value == "banner") {
            //hapus old image
            Storage::disk('local')->delete('public/website-information/'.$news->image);

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/website-information', $image->hashName());

            $news->update([
                'image'     => $image->hashName(),
            ]);
        }elseif($request->kategori_value == "visi_misi")

            $settings->update([
                'desc'     => $request->visi_misi,
            ]);
        else{

            if($request->file('image') == "") {
    
                $settings->update([
                    'name'     => $request->website_name,
                    'email'   => $request->website_email,
                    'phone'   => $request->website_phone,
                    'address'   => $request->website_address,
                    'updated_at'   => now(),
                ]);
    
            } else {
    
                //hapus old image
                Storage::disk('local')->delete('public/website-information/'.$news->image);
    
                //upload new image
                $image = $request->file('image');
                $image->storeAs('public/website-information', $image->hashName());
    
                $news->update([
                    'image'     => $image->hashName(),
                    'name'     => $request->website_name,
                    'email'   => $request->website_email,
                    'phone'   => $request->website_phone,
                    'address'   => $request->website_address,
                    'updated_at'   => now(),
                ]);
    
            }
        }


        
        if($settings){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil DiUpdate!');
            return redirect()->route('admin-setting.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal DiUpdate!');
            return redirect()->route('admin-setting.index');
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
