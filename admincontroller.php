<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class admincontroller
{
    public function add_gatagory_function(Request $req)
    {
     
        $data=$req->validate([
            'gatagory_name'=>'required|unique:video_gatagory|max:100',
            
      ]);



        $user=DB::table('video_gatagory')
        ->insert([
               'gatagory_name'=>$req->gatagory_name,
     ]);
     if($user)
     {
        return redirect('gatagory')->with('msg',"new reocrd added suucfully");
     }

    }


    public function home_page(){
        $gatagory=DB::table('video_gatagory')->get();
        $videos=DB::table('video_view')->get();

        return view('viewrs.home',compact('gatagory','videos'));
    }
    
    public function view_video($id){

        $videos=DB::table('video_view')
        ->where('video_id',$id)
        ->get();

        $get=DB::table('video_view')
        ->where('video_id',$id)
        ->get();

     $getid='';

          foreach ($get as  $value) {
            $getid.=$value->acount_id;
              
          }


            $sub=DB::table('sub')
            ->where('channel_wallah',$getid)->count('channel_wallah');
            
            return view('viewrs.palyvideo',compact('videos','sub'));
        

    }

    public function sub_channel($id)
    {
       
        $s=session()->get('user_id');

        $r=$s->make_id;



        $sub=DB::table('sub')
        ->where('sub_wallah',$r)->where('channel_wallah',$id)->get();
     if(count($sub)>0){

      $un=DB::table('sub')->where('sub_wallah',$r)
      ->where('channel_wallah',$id)->delete();
      if($un){
        return redirect("youtube")->with('unsub',"You Unspscript The Channel");
      }



      
     

      // $user=DB::table('sub')
      // ->insert([
      //        'sub_wallah'=>$r,
      //        'channel_wallah'=>$id,
  
      //   ]);

      //   if($user){

      //     return redirect("youtube")->with('sub',"thanks form your subscription");
  
      //    }

     }else{

      $user=DB::table('sub')
      ->insert([
             'sub_wallah'=>$r,
             'channel_wallah'=>$id,
  
        ]);

        if($user){

          return redirect("youtube")->with('sub',"thanks form your subscription");
  
         }

     }

     

     
    
      






       

        


           
    }



     
    public function view_my_channel($channel_id){

        $channel=DB::table('users')
        ->where('user_id',$channel_id)
        ->get();

        $videos=DB::table('video_view')
        ->where('acount_id',$channel_id)
        ->get();


        $get=DB::table('users')
        ->where('user_id',$channel_id)
        ->get();

        $getid='';

        foreach ($get as  $value) {
          $getid.=$value->user_id;
            
        }


          $sub=DB::table('sub')
          ->where('channel_wallah',$getid)->count('channel_wallah');
          



        return view('viewrs.channelview',compact('channel','videos','sub'));

    }

    public function channel_video_view($id)
    {
        $chanel_video=DB::table('video_view')
        ->where('video_id',$id)
        ->get();

        $channel=DB::table('users')
        ->where('user_id',$id)
        ->get();


        $get=DB::table('video_view')
        ->where('video_id',$id)
        ->get();


        $getid='';

        foreach ($get as  $value) {
          $getid.=$value->user_id;
            
        }


          $sub=DB::table('sub')
          ->where('channel_wallah',$getid)->count('channel_wallah');
          

        return view('viewrs.palyvideo',compact('chanel_video','channel','sub'));


    }


    public function gatagory_show_fun($id){

        $gatagory_video=DB::table('video_view')
        ->where('gatagory_join_id',$id)
        ->get();

        $gatagory=DB::table('video_gatagory')->get();

        return view('viewrs.home',compact('gatagory_video','gatagory'));

    }


    public function create_acount_fun(Request $req){


         
        $data=$req->validate([
            'make_email'=>'required|unique:making_acount|max:50|email',
            'make_password'=>'required|unique:making_acount|max:50',
            
      ]);

      $user=DB::table('making_acount')
      ->insert([
             'make_email'=>$req->make_email,
             'make_password'=>$req->make_password,
        ]);

        if($user)
        {
            return redirect('useracount')->with('msg','acount created sussccfuly');
        }


    }

    public function userlogin(Request $req){
        $data=$req->validate([
            'make_email'=>'required|email',
            'make_password'=>'required',
            
      ]);

      if($data){


        $result=DB::table('making_acount')->where('make_email',$req->make_email)
        ->where('make_password',$req->make_password)
        ->get();

        if($result->isNotEmpty())
        {

 
           $req->session()->put('user_id',$result[0]);
           return redirect('youtube');
          
        }
        else{
            // return $req;

          return redirect('userlogin')->with('msg','invalid email or password');
        }

    }

    }

    public function userlogout(Request $req)
    {
       $req->session()->forget('user_id');
       return redirect('userlogin')->with('msg','succesfuly logout');



    }












    public function search_video($value)
    {
        return 'kkk';
    }









}
