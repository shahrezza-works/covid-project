<?php

namespace App\Http\Controllers\Open;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Modal\Location;
use App\Modal\Respon;
use App\Modal\Jabatan;
use App\Modal\Respon_staff;
use App\Modal\Respon_kontraktor;
use DB;

class FormController extends Controller
{
    public function main($unique_id)
    {   
        //Generate form here
        // $location = Location::where('md5(id) = "'.$unique_id.'"')->first();
        $location = DB::table('location')->whereRaw('md5(id) = "'.$unique_id.'" AND remove = 0')->first();
        // echo '<pre>';
        // var_dump($location); 
        // echo '</pre>';

        if(empty($location)){
            return view('open.errorremove');
        }

        $variables['location_id'] = $location->id;
        $variables['nama_premis'] = $location->nama_premis;
        $variables['nama_bangunan'] = $location->nama_bangunan;
        $variables['kawasan'] = $location->kawasan;
        $variables['type'] = $location->type; //either self declaration / front-liner will keyin this
        // exit;
        return view('open.form', $variables);
    }

    public function submit($location_id, Request $request)
    {
        // var_dump($location_id);
        // echo '<pre>';
        // var_dump($request->input());
        // echo '</pre>';
        // exit;

        if($location_id != $request->lid){
            return view('open.errorsubmit');
        }

        $location = DB::table('location')->whereRaw('md5(id) = "'.$location_id.'"')->first();

        if(empty($location)){
            return view('open.errorsubmit');
        }

        $id = $location->id;
        $nama = $request->input('nama');
        $no_tel = $request->input('no_tel');
        $suhu = $request->input('suhu');
        $verify = $request->input('verify');
        $agree = $request->input('agree');
        $date = date(now());
        
        $duplicate = DB::table('respon')->whereRaw('md5(form_id) = "'.$location_id.'" 
        AND phone = "'.$no_tel.'" AND DATE(created_at) = DATE("'.$date.'")')->first();

        if(!empty($duplicate)){
            return redirect('/form/'.$location_id)->with('status_error','Pendaftaran Tidak Berjaya. Nombor telefon yang dimasukkan telah didaftarkan hari ini!');
        }

        $record = Respon::insert(
            [
                'form_id' => $id,
                'name' => $nama,
                'phone' => $no_tel,
                'verify' => $verify,
                'agree' => $agree,
                'suhu' => $suhu,
                'created_at' => $date,
                'updated_at' => $date,
            ]
        );

        $variables['nama_premis'] = $location->nama_premis;
        $variables['nama_bangunan'] = $location->nama_bangunan;
        $variables['kawasan'] = $location->kawasan;
        $variables['waktu_pendaftaran'] = date('d M Y (h:i a)', time());
        $variables['no_tel'] = $no_tel;

        $suhu = ($location->type == 0) ? false : $suhu>=37.5;
        if($verify == 1 || $suhu){
            $danger = 1;
        }else{
            $danger = 0;
        }

        if($record){
            return redirect('/form/receipt/summary?loc='.$location_id.'&t='.time().'&p='.urlencode($no_tel).'&alert='.$danger);
        }else{
            return view('open.errorsubmit');
        }
    }

    public function receipt(Request $request)
    {   
        $location_id = $request->get('loc');
        $time = $request->get('t');
        $phone = $request->get('p');
        $alert = $request->get('alert');

        if(empty($location_id) || empty($time)){
            return view('open.errorsubmit');
        }

        if($alert == '' || $alert == 0){
            $variables['danger'] = false;
        }else{
            $variables['danger'] = true;
        }

        $location = DB::table('location')->whereRaw('md5(id) = "'.$location_id.'"')->first();

        $variables['nama_premis'] = $location->nama_premis;
        $variables['nama_bangunan'] = $location->nama_bangunan;
        $variables['kawasan'] = $location->kawasan;
        $variables['waktu_pendaftaran'] = date('d M Y (h:i a)', $time);
        $variables['no_tel'] = $phone;
        $variables['no_pekerja'] = '';
        
        return view('open.success', $variables);
    }

    public function staff_form($unique_id)
    {
        $location = DB::table('location')->whereRaw('md5(id) = "'.$unique_id.'" AND remove = 0')->first();
        $jabatan = Jabatan::where(['remove'=>0])->orderBy('name')->get();

        if(empty($location)){
            return view('open.errorremove');
        }
        
        // echo '<pre>';
        // var_dump($jabatan);
        // echo '</pre>';
        // exit;

        $variables['location_id'] = $location->id;
        $variables['nama_premis'] = $location->nama_premis;
        $variables['nama_bangunan'] = $location->nama_bangunan;
        $variables['kawasan'] = $location->kawasan;
        $variables['jabatan'] = $jabatan;
        $variables['type'] = $location->type; //either self declaration / front-liner will keyin this
        // exit;
        return view('open.formstaff', $variables);
    }

    public function staff_submit($location_id, Request $request)
    {
        // var_dump($location_id);
        // echo '<pre>';
        // var_dump($request->input());
        // echo '</pre>';
        // exit;

        if($location_id != $request->input('lid')){
            return view('open.errorsubmit');
        }

        $location = DB::table('location')->whereRaw('md5(id) = "'.$location_id.'"')->first();

        if(empty($location)){
            return view('open.errorsubmit');
        }

        $form_id = $location->id;
        $nama = $request->input('nama');
        $no_pekerja = strtoupper($request->input('no_pekerja'));
        $jabatan = $request->input('jabatan');

        $demam = $request->input('demam');
        $selsema = $request->input('selsema');
        $batuk = $request->input('batuk');
        $sesak_nafas = $request->input('sesak_nafas');
        $sakit_sendi = $request->input('sakit_sendi');
        $deria_rasa = $request->input('deria_rasa');

        $deklarasi_1 = $request->input('deklarasi_1');
        $deklarasi_2 = $request->input('deklarasi_2');
        $deklarasi_3 = $request->input('deklarasi_3');

        $suhu = $request->input('suhu');
        $agree = $request->input('agree');

        $clockin = $request->input('clockin');

        $date = date(now());

        $duplicate = DB::table('respon_staff')->whereRaw('md5(form_id) = "'.$location_id.'" 
        AND no_pekerja = "'.$no_pekerja.'" AND DATE(created_at) = DATE("'.$date.'")')->first();

        if(!empty($duplicate)){
            return redirect('/form/staff/'.$location_id)->with('status_error','Pendaftaran Tidak Berjaya. Nombor pekerja yang dimasukkan telah didaftarkan hari ini!');
        }

        $record = Respon_staff::insert(
            [
                'form_id' => $form_id,
                'nama' => $nama,
                'no_pekerja' => $no_pekerja,
                'jabatan' => $jabatan,
                'demam' => $demam,
                'selsema' => $selsema,
                'batuk' => $batuk,
                'sesak_nafas' => $sesak_nafas,
                'sakit_sendi' => $sakit_sendi,
                'deria_rasa' => $deria_rasa,
                'deklarasi_1' => $deklarasi_1,
                'deklarasi_2' => $deklarasi_2,
                'deklarasi_3' => $deklarasi_3,
                'agree' => $agree,
                'suhu' => $suhu,
                'clockin' => $clockin,
                'created_at' => $date,
                'updated_at' => $date,
            ]
        );

        $point = $demam+$selsema+$batuk+$sesak_nafas+$sakit_sendi+$deria_rasa+$deklarasi_1+$deklarasi_2+$deklarasi_3;
        $suhu = ($location->type == 0) ? false : $suhu>=37.5;
        if($point > 0 || $suhu){
            $danger = 1;
        }else{
            $danger = 0;
        }

        if($record){
            return redirect('/form/receipt/staff/summary?loc='.$location_id.'&t='.time().'&p='.urlencode($no_pekerja).'&alert='.$danger.'&clockin='.urlencode($clockin))
                ->withCookie(cookie()->forever('nama', $nama))
                ->withCookie(cookie()->forever('no_pekerja', $no_pekerja))
                ->withCookie(cookie()->forever('jabatan', $jabatan))
                ;
        }else{
            return view('open.errorsubmit');
        }
    }

    public function staff_clockout()
    {
        return view('open.timeclock');
    }

    public function staff_clockoutprocess(Request $request)
    {
        // echo '<pre>';
        // var_dump($request->input());
        // echo '</pre>';
        // exit();

        $date = $request->input('date');
        $clockout = date('H:i:s'); //overwrite time at UI
        $clockout = $request->input('clockout');
        $no_pekerja = $request->input('no_pekerja');

        $record = DB::table('respon_staff')->whereRaw('DATE(created_at) = "'.$date.'" AND no_pekerja = "'.$no_pekerja.'"')->first();

        if(empty($record)){
            return view('open.timeclocknoclockin');
        }

        $affected = DB::table('respon_staff')
              ->where('id', $record->id)
              ->update(['clockout' => $clockout]);

        $variables['nama'] = $record->nama;
        $variables['time_clockout'] = $clockout;

        // echo '<pre>';
        // var_dump($affected);
        // echo '</pre>';
        // exit();
        
        if($affected){
            return view('open.timeclocksuccess', $variables)->withCookie(cookie()->forever('no_pekerja', $no_pekerja));
        }else{
            return view('open.timeclockfailed');
        }

        
    }

    public function receipt_staff(Request $request)
    {   
        $location_id = $request->get('loc');
        $time = $request->get('t');
        $no_pekerja = $request->get('p');
        $alert = $request->get('alert');

        if(empty($location_id) || empty($time)){
            return view('open.errorsubmit');
        }

        if($alert == '' || $alert == 0){
            $variables['danger'] = false;
        }else{
            $variables['danger'] = true;
        }

        $location = DB::table('location')->whereRaw('md5(id) = "'.$location_id.'"')->first();

        $variables['nama_premis'] = $location->nama_premis;
        $variables['nama_bangunan'] = $location->nama_bangunan;
        $variables['kawasan'] = $location->kawasan;
        $variables['waktu_pendaftaran'] = date('d M Y (h:i a)', $time);
        $variables['no_tel'] = '';
        $variables['no_pekerja'] = $no_pekerja;
        
        return view('open.success', $variables);
    }

    public function kontraktor_form($unique_id)
    {
        $location = DB::table('location')->whereRaw('md5(id) = "'.$unique_id.'" AND remove = 0')->first();

        if(empty($location)){
            return view('open.errorremove');
        }
        
        // echo '<pre>';
        // var_dump($jabatan);
        // echo '</pre>';
        // exit;

        $variables['location_id'] = $location->id;
        $variables['nama_premis'] = $location->nama_premis;
        $variables['nama_bangunan'] = $location->nama_bangunan;
        $variables['kawasan'] = $location->kawasan;
        $variables['type'] = $location->type; //either self declaration / front-liner will keyin this
        // exit;
        return view('open.formkontraktor', $variables);
    }

    public function kontraktor_submit($location_id, Request $request)
    {
        // var_dump($location_id);
        // echo '<pre>';
        // var_dump($request->input());
        // echo '</pre>';
        // exit;

        if($location_id != $request->input('lid')){
            return view('open.errorsubmit');
        }

        $location = DB::table('location')->whereRaw('md5(id) = "'.$location_id.'"')->first();

        if(empty($location)){
            return view('open.errorsubmit');
        }

        $form_id = $location->id;
        $nama = $request->input('nama');
        $no_tel = $request->input('no_tel');
        $nama_syarikat = $request->input('nama_syarikat');

        $demam = $request->input('demam');
        $selsema = $request->input('selsema');
        $batuk = $request->input('batuk');
        $sesak_nafas = $request->input('sesak_nafas');
        $sakit_sendi = $request->input('sakit_sendi');
        $deria_rasa = $request->input('deria_rasa');

        $deklarasi_1 = $request->input('deklarasi_1');
        $deklarasi_2 = $request->input('deklarasi_2');
        $deklarasi_3 = $request->input('deklarasi_3');

        $suhu = $request->input('suhu');
        $agree = $request->input('agree');

        $date = date(now());

        $duplicate = DB::table('respon_kontraktor')->whereRaw('md5(form_id) = "'.$location_id.'" 
        AND no_tel = "'.$no_tel.'" AND DATE(created_at) = DATE("'.$date.'")')->first();

        if(!empty($duplicate)){
            return redirect('/form/kontraktor/'.$location_id)->with('status_error','Pendaftaran Tidak Berjaya. Nombor telefon yang dimasukkan telah didaftarkan hari ini!');
        }

        $record = Respon_kontraktor::insert(
            [
                'form_id' => $form_id,
                'nama' => $nama,
                'no_tel' => $no_tel,
                'nama_syarikat' => $nama_syarikat,
                'demam' => $demam,
                'selsema' => $selsema,
                'batuk' => $batuk,
                'sesak_nafas' => $sesak_nafas,
                'sakit_sendi' => $sakit_sendi,
                'deria_rasa' => $deria_rasa,
                'deklarasi_1' => $deklarasi_1,
                'deklarasi_2' => $deklarasi_2,
                'deklarasi_3' => $deklarasi_3,
                'agree' => $agree,
                'suhu' => $suhu,
                'created_at' => $date,
                'updated_at' => $date,
            ]
        );

        $point = $demam+$selsema+$batuk+$sesak_nafas+$sakit_sendi+$deria_rasa+$deklarasi_1+$deklarasi_2+$deklarasi_3;
        $suhu = ($location->type == 0) ? false : $suhu>=37.5;
        if($point > 0 || $suhu){
            $danger = 1;
        }else{
            $danger = 0;
        }

        if($record){
            return redirect('/form/receipt/summary?loc='.$location_id.'&t='.time().'&p='.urlencode($no_tel).'&alert='.$danger);
        }else{
            return view('open.errorsubmit');
        }
    }
}
