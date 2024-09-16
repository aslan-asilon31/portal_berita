<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\User;
use App\Models\MasterCatPost;
use App\Models\MasterTypePost;
use App\Models\Settings;
use Illuminate\Session\TokenMismatchException;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\Theme;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminSusunanRedaksiController extends Controller
{
    public function index()
    {
        $theme = Theme::where('is_active',1)->first();
        $logo = Settings::where('category','logo')->first();
        // Mengambil data pengguna dikelompokkan berdasarkan title
        $usersGroupedByTitle = User::select('id', 'title', 'sequence', 'jabatan', 'name', 'image')
        ->whereNot('jabatan', 'admin')
        ->orderByRaw("title = 'PIMPINAN-PUSAT' DESC") 
        ->orderBy('sequence')
        ->get()
        ->groupBy('title');

        return view('admin_susunan_redaksi', compact('theme','usersGroupedByTitle','logo'));
    }

     
    public function create(){
        $list_sequences = []; 

        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();
        $cat_posts = MasterCatPost::whereIn('id',['1','2','8','9'])->get();
        $categories = User::whereNotNull('kategori') // Exclude null values
                    ->where('kategori', '!=', '') // Exclude empty strings
                    ->distinct()
                    ->pluck('kategori');

        $jabatan = User::whereNotNull('jabatan') // Exclude null values
                    ->where('jabatan', '!=', '') // Exclude empty strings
                    ->distinct()
                    ->pluck('jabatan');
        $title = User::whereNotNull('title') // Exclude null values
                    ->distinct()
                    ->pluck('title');

        $usersGroupedByTitle = User::select('id','title', 'sequence','jabatan', 'name', 'image')
                    ->orderBy('title')
                    ->whereNot('jabatan','admin')
                    ->orderBy('sequence')
                    ->get()
                    ->groupBy('title');

        foreach ($usersGroupedByTitle as $title => $users) {
            foreach ($users as $user) {
                $listed_sequences[$title][] = $user->sequence;
            }
        }


        return view('admin_susunan_redaksi_form', compact('usersGroupedByTitle','listed_sequences','title','theme','jabatan','categories','cat_posts','logo'));
    }
     
    public function divisi_create(){
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();
        $cat_posts = MasterCatPost::whereIn('id',['1','2','8','9'])->get();
        $categories = User::whereNotNull('kategori') // Exclude null values
                    ->where('kategori', '!=', '') // Exclude empty strings
                    ->distinct()
                    ->pluck('kategori');

        $jabatan = User::whereNotNull('jabatan') // Exclude null values
                    ->where('jabatan', '!=', '') // Exclude empty strings
                    ->distinct()
                    ->pluck('jabatan');

        return view('admin_susunan_redaksi_divisi_form', compact('theme','jabatan','categories','cat_posts','logo'));
    }
     
    public function jabatan_create(){
        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();
        $cat_posts = MasterCatPost::whereIn('id',['1','2','8','9'])->get();
        $categories = User::whereNotNull('kategori') // Exclude null values
                    ->where('kategori', '!=', '') // Exclude empty strings
                    ->distinct()
                    ->pluck('kategori');

        $jabatan = User::whereNotNull('jabatan') // Exclude null values
                    ->where('jabatan', '!=', '') // Exclude empty strings
                    ->distinct()
                    ->pluck('jabatan');

        return view('admin_susunan_redaksi_jabatan_form', compact('theme','jabatan','categories','cat_posts','logo'));
    }

    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            //upload image
            $image = $request->file('image');
            $image->storeAs('public/users', $image->hashName());
            
            $users = User::create([
                'image'     => $image->hashName(),
                'name'     => $request->name,
                'email'     => $request->email,
                'kategori'   => 'pimpinan-redaksi',
                'jabatan'   => $request->jabatan_susunan_redaksi,
                'title'   => $request->divisi_susunan_redaksi,
                'sequence'   => $request->sequence,
            ]);

        }else{

            $users = User::create([
                'name'     => $request->name,
                'email'     => $request->email,
                'kategori'   => 'pimpinan-redaksi',
                'jabatan'   => $request->jabatan_susunan_redaksi,
                'title'   => $request->divisi_susunan_redaksi,
                'sequence'   => $request->sequence,

            ]);

        }

        if($users){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-susunan-redaksi.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-susunan-redaksi.index');
        }

    }

    public function store_divisi(Request $request)
    {
        
        $users = User::create([
            'title'   => $request->title,
        ]);

        if($users){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-susunan-redaksi.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-susunan-redaksi.index');
        }

    }

    public function store_jabatan(Request $request)
    {
        
        $users = User::create([
            'jabatan'   => $request->jabatan,
        ]);

        if($users){
            //redirect dengan pesan sukses
            Alert::success('Sukses', 'Data Berhasil Disimpan!');
            return redirect()->route('admin-susunan-redaksi.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Disimpan!');
            return redirect()->route('admin-susunan-redaksi.index');
        }

    }

    public function edit($id)
    {

        $theme = Theme::where('is_active',1)->first();

        $logo = Settings::where('category','logo')->first();

        $categories = User::whereNotNull('kategori')
        ->select('kategori')
        ->groupBy('kategori')
        ->get();

        $title = User::whereNotNull('title') // Exclude null values
        ->distinct()
        ->pluck('title');
        
        $jabatans = User::whereNotNull('jabatan')
        ->select('jabatan')
        ->groupBy('jabatan')
        ->get();

        $user = User::where('id',$id)->first();


        if (!$user) {
            abort(404, 'News not found.');
        }
        
        $usersGroupedByTitle = User::select('id','title', 'sequence','jabatan', 'name', 'image')
                    ->orderBy('title')
                    ->whereNot('jabatan','admin')
                    ->orderBy('sequence')
                    ->get()
                    ->groupBy('title');

        foreach ($usersGroupedByTitle as $title => $users_div) {
            foreach ($users_div as $user_div) {
                $listed_sequences[$title][] = $user_div->sequence;
            }
        }

        return view('admin_susunan_redaksi_form_edit', compact('usersGroupedByTitle','listed_sequences','title','theme','logo','user','jabatans','categories'));
    }

    public function update(Request $request, $id)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::findOrFail($id);
    
        // Validasi input
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id, // Validasi email untuk update
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Jika ada gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($user->image && File::exists(public_path('PORTAL-BERITA-ASSET/users/' . $user->image))) {
                File::delete(public_path('PORTAL-BERITA-ASSET/users/' . $user->image));
            }
    
            // Upload gambar baru
            $file = $request->file('image');
            $fileName = time() . '.' . $file->getClientOriginalExtension(); // Membuat nama file unik
            $destinationPath = public_path('PORTAL-BERITA-ASSET/users');
            
            // Pastikan folder tujuan ada
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
    
            // Simpan file ke folder 'public/users'
            $file->move($destinationPath, $fileName);
    
            // Set nama file baru
            $user->image = $fileName;
        }
    
        // Update informasi model dengan data dari request
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'kategori' => $request->kategori_susunan_redaksi,
            'jabatan' => $request->jabatan_susunan_redaksi,
            'title' => $request->divisi_susunan_redaksi,
            'sequence' => $request->sequence,
            'image' => $user->image, // Menyimpan nama gambar baru
        ]);
    
        Alert::success('Sukses', 'Data Berhasil Di Update!');
        return redirect()->route('admin-susunan-redaksi.index');
    }
    
    

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        Storage::disk('local')->delete('public/users/'.$users->image);
        $users->delete();

        if($users){
            Alert::success('Sukses', 'Data Berhasil Dihapus!');
            return redirect()->route('admin-susunan-redaksi.index');
        }else{
            //redirect dengan pesan error
            Alert::warning('Error', 'Data Gagal Dihapus!');
            return redirect()->route('admin-susunan-redaksi.index');
        }
    }

    public function chartOrg()
    {
     
        // Mengambil data pengguna dikelompokkan berdasarkan title
            $usersGroupedByTitle = User::select('title', 'sequence', 'name', 'image')
            ->orderBy('title')
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

        
        

        return view('admin_susunan_redaksi_org_chart', compact('usersGroupedByTitle','nodes', 'data'));
    }


    public function getUserDetails(Request $request) {

        $user = User::find($request->id);
        if ($user) {
            return response()->json([
                'name' => $user->name,
                'jabatan' => $user->jabatan,
                'image' => $user->image,
            ]);
        }
        return response()->json(['error' => 'User not found'], 404);
    }

}
