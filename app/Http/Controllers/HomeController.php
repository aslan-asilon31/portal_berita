<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\MasterCatPost;
use App\Models\MasterTypePost;
use Illuminate\Session\TokenMismatchException;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use App\Models\Theme;
use App\Models\Settings;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $logo = Settings::where('category','logo')->first();
        $theme = Theme::where('is_active',1)->first();
        $news = News::with('masterCatPost')
                ->orderBy('created_at', 'desc')
                ->get();
        return view('admin_beranda', compact('theme','logo','news'));
    }

    
}
