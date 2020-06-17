<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modal\Location;
use App\Modal\Respon;
use Auth;
use DB;

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

    public function dashboard()
    {
        if(Auth::user()->usertype == -1){
            $respon = Respon::all()->count();
            $unique_respon = DB::table('respon')
                ->select('phone')
                ->distinct('phone')
                ->get()->count();

            $suhu_normal = DB::select('select count(respon.id) AS count from respon where respon.suhu is not null and respon.suhu < 37.5');
            $suhu_xnormal = DB::select('select count(respon.id) AS count from respon where respon.suhu is not null and respon.suhu >= 37.5');
            $suhu_null = DB::select('select count(respon.id) AS count from respon where respon.suhu is null');
            // var_dump($suhu_null[0]->count); exit;
        }else{
            $user_id = Auth::user()->id;
            
            $respon = DB::table('respon')
                ->leftJoin('location', 'location.id', 'respon.form_id')
                ->where([['remove','=','0'],['user_id', '=', $user_id]])
                ->get()->count();
            
            $unique_respon = DB::table('respon')
                ->select('phone')
                ->leftJoin('location', 'location.id', 'respon.form_id')
                ->where([['remove','=','0'],['user_id', '=', $user_id]])
                ->distinct('phone')
                ->get()->count();

            $suhu_normal = DB::select('select count(respon.id) AS count from respon left join location on (location.id = respon.form_id) where respon.suhu is not null and respon.suhu < 37.5 and user_id = '.$user_id);
            $suhu_xnormal = DB::select('select count(respon.id) AS count from respon left join location on (location.id = respon.form_id) where respon.suhu is not null and respon.suhu >= 37.5 and user_id = '.$user_id);
            $suhu_null = DB::select('select count(respon.id) AS count from respon left join location on (location.id = respon.form_id) where respon.suhu is null and user_id = '.$user_id);
            // var_dump($suhu_normal); exit;
        }
        // var_dump($respon); exit;
        $variables['total_respon'] = $respon;
        $variables['total_unique_respon'] = $unique_respon;

        $variables['suhu_normal'] = $suhu_normal[0]->count;
        $variables['suhu_xnormal'] = $suhu_xnormal[0]->count;
        $variables['suhu_null'] = $suhu_null[0]->count;

        return view('admin.dashboard', $variables);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return redirect('/dashboard');
    }
}
