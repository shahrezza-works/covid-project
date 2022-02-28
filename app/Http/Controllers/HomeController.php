<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modal\Location;
use App\Modal\Respon;
use App\Modal\Respon_staff;
use App\Modal\Respon_kontraktor;
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
            $respon = Respon::all()->count() + Respon_staff::all()->count() + Respon_kontraktor::all()->count();
            $unique_respon = DB::table('respon')
                ->select('phone')
                ->distinct('phone')
                ->get()->count() + 
                DB::table('respon_staff')
                ->select('no_pekerja')
                ->distinct('no_pekerja')
                ->get()->count() +
                DB::table('respon_kontraktor')
                ->select('no_tel')
                ->distinct('no_tel')
                ->get()->count();

            // $suhu_normal = DB::select('SELECT SUM(MAIN.count) AS count FROM (select count(respon.id) AS count from respon where respon.suhu is not null and respon.suhu < 37.5
            // UNION ALL select count(respon_staff.id) AS count from respon_staff where respon_staff.suhu is not null and respon_staff.suhu < 37.5 
            // UNION ALL select count(respon_kontraktor.id) AS count from respon_kontraktor where respon_kontraktor.suhu is not null and respon_kontraktor.suhu < 37.5) MAIN');
            // $suhu_xnormal = DB::select('SELECT SUM(MAIN.count) AS count FROM (select count(respon.id) AS count from respon where respon.suhu is not null and respon.suhu >= 37.5
            // UNION ALL select count(respon_staff.id) AS count from respon_staff where respon_staff.suhu is not null and respon_staff.suhu >= 37.5 
            // UNION ALL select count(respon_kontraktor.id) AS count from respon_kontraktor where respon_kontraktor.suhu is not null and respon_kontraktor.suhu >= 37.5) MAIN');
            // $suhu_null = DB::select('SELECT SUM(MAIN.count) AS count FROM (select count(respon.id) AS count from respon where respon.suhu is null
            // UNION ALL select count(respon_staff.id) AS count from respon_staff where respon_staff.suhu is null
            // UNION ALL select count(respon_kontraktor.id) AS count from respon_kontraktor where respon_kontraktor.suhu is null) MAIN');
            // var_dump($suhu_xnormal); exit;
        }else{
            $user_id = Auth::user()->id;
            
            $respon = DB::table('respon')
                ->leftJoin('location', 'location.id', 'respon.form_id')
                ->where([['remove','=','0'],['user_id', '=', $user_id]])
                ->whereYear('respon.created_at', '2022')
                ->get()->count() + 
                DB::table('respon_staff')
                ->leftJoin('location', 'location.id', 'respon_staff.form_id')
                ->where([['remove','=','0'],['user_id', '=', $user_id]])
                ->whereYear('respon_staff.created_at', '2022')
                ->get()->count() +
                DB::table('respon_kontraktor')
                ->leftJoin('location', 'location.id', 'respon_kontraktor.form_id')
                ->where([['remove','=','0'],['user_id', '=', $user_id]])
                ->whereYear('respon_kontraktor.created_at', '2022')
                ->get()->count();
            
            /* $unique_respon = DB::table('respon')
                ->select('phone')
                ->leftJoin('location', 'location.id', 'respon.form_id')
                ->where([['remove','=','0'],['user_id', '=', $user_id]])
                ->distinct('phone')
                ->get()->count() + 
                DB::table('respon_staff')
                ->select('no_pekerja')
                ->leftJoin('location', 'location.id', 'respon_staff.form_id')
                ->where([['remove','=','0'],['user_id', '=', $user_id]])
                ->distinct('no_pekerja')
                ->get()->count() + 
                DB::table('respon_kontraktor')
                ->select('no_tel')
                ->leftJoin('location', 'location.id', 'respon_kontraktor.form_id')
                ->where([['remove','=','0'],['user_id', '=', $user_id]])
                ->distinct('no_tel')
                ->get()->count(); */

            // $suhu_normal = DB::select('SELECT SUM(MAIN.count) AS count FROM (select count(respon.id) AS count from respon left join location on (location.id = respon.form_id) where respon.suhu is not null and respon.suhu < 37.5 and user_id = '.$user_id.
            // ' UNION ALL select count(respon_staff.id) AS count from respon_staff left join location on (location.id = respon_staff.form_id) where respon_staff.suhu is not null and respon_staff.suhu < 37.5 and user_id = '.$user_id.
            // ' UNION ALL select count(respon_kontraktor.id) AS count from respon_kontraktor left join location on (location.id = respon_kontraktor.form_id) where respon_kontraktor.suhu is not null and respon_kontraktor.suhu < 37.5 and user_id = '.$user_id.' ) MAIN');
            // $suhu_xnormal = DB::select('SELECT SUM(MAIN.count) AS count FROM (select count(respon.id) AS count from respon left join location on (location.id = respon.form_id) where respon.suhu is not null and respon.suhu >= 37.5 and user_id = '.$user_id.
            // ' UNION ALL select count(respon_staff.id) AS count from respon_staff left join location on (location.id = respon_staff.form_id) where respon_staff.suhu is not null and respon_staff.suhu >= 37.5 and user_id = '.$user_id.
            // ' UNION ALL select count(respon_kontraktor.id) AS count from respon_kontraktor left join location on (location.id = respon_kontraktor.form_id) where respon_kontraktor.suhu is not null and respon_kontraktor.suhu >= 37.5 and user_id = '.$user_id.') MAIN');
            // $suhu_null = DB::select('SELECT SUM(MAIN.count) AS count FROM (select count(respon.id) AS count from respon left join location on (location.id = respon.form_id) where respon.suhu is null and user_id = '.$user_id.
            // ' UNION ALL select count(respon_staff.id) AS count from respon_staff left join location on (location.id = respon_staff.form_id) where respon_staff.suhu is null and user_id = '.$user_id.
            // ' UNION ALL select count(respon_kontraktor.id) AS count from respon_kontraktor left join location on (location.id = respon_kontraktor.form_id) where respon_kontraktor.suhu is null and user_id = '.$user_id.') MAIN');
            // var_dump($suhu_normal); exit;
        }
        // var_dump($respon); exit;
        $variables['total_respon'] = $respon;
        /* $variables['total_unique_respon'] = $unique_respon; */

        // $variables['suhu_normal'] = $suhu_normal[0]->count;
        // $variables['suhu_xnormal'] = $suhu_xnormal[0]->count;
        // $variables['suhu_null'] = $suhu_null[0]->count;

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
