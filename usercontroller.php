<?php

namespace App\Http\Controllers;
// use App\Http\Middleware\loginme; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class usercontroller
{
    public function StoreUserData(Request $req)  {

     
        $data=$req->validate([
            'email'=>'required|unique:users',
            'password'=>'required|unique:users',
            'channel_name'=>'required|unique:users|max:50',
            'description'=>'required|max:500',
            'channel_img'=>'required',
       
     

      ]);

    //    $show=User::create($data);
    $tbl=new User;

    $photo="PHOTO".time().".".$req->channel_img->extension();
    $req->channel_img->move(public_path('userimg'),$photo);

       $tbl->password=$req->password;
       $tbl->email=$req->email;
       $tbl->channel_name=$req->channel_name;
       $tbl->description=$req->description;
       $tbl->channel_img=$photo;
       $tbl->save();


       if($tbl)
       {
        // return redirect()->route("login");

       return view("viewrs.creatacout",['message'=>'Added Reocrd']);

       }

    }
     
    public function login(Request $req)
    {
        
        $email=$req->email;
        $password=$req->channel_name;

        $credentials=$req->validate([
            'email'=>'required|email',
            'channel_name'=>'required',  
           
        ]);
        if($credentials){


          $result=User::where('email',$email)
          ->where('channel_name',$password)
          ->get();

          if($result->isNotEmpty())
          {

   
             $req->session()->put('uid',$result[0]);
             return redirect('home');
            
          }
          else{

            return redirect('login')->with('msg','invalid email or password');
          }

      }
     
    }


    public function view_profile($id)
    {
    //    if($id)
    //    {
        $record=User::where('user_id',$id)->get();
    
        
        $get=DB::table('users')
        ->where('user_id',$id)
        ->get();

        $getid='';

          foreach ($get as  $value) {
            $getid.=$value->user_id;
              
          }


            $sub=DB::table('sub')
            ->where('channel_wallah',$getid)->count('channel_wallah');
            



        return view("acount.view_profile",compact('record','sub'));
    //    }
    //    else{
    //     return redirect('home');
    //    }
    }
    public function update_profile_view($id)
    {
        $record=User::where('user_id',$id)->get();
    
        return view('acount.update_profile',compact('record'));
    }
    
    public function update_my_profile_function(Request $req,string $id)
    {

        $data=$req->validate([
            'email'=>'required',
            'password'=>'required|max:60',
            'channel_name'=>'required|max:50',
            'description'=>'required|max:500',   
            // 'channel_img'=>'required',   
     

      ]);
      if($data){
      
        $photo="PHOTO".time().".".$req->channel_img->extension();
        $req->channel_img->move(public_path('userimg'),$photo);

        $user=DB::table('users')->where('user_id',$id)
        ->update([
        'email'=>$req->email,
        'password'=>$req->password,
        'channel_name'=>$req->channel_name,
        'channel_img'=>$photo,
        'description'=>$req->description,
     ]);
    }

     if($user)
     {

        return redirect('home')->with('updated',"update");
        

     }
    }

    public function Dleted_acount($id)
    {
        $record=User::where('user_id',$id)->delete();
        if($record)
        {
               session()->forget('uid');
              return redirect('login')->with('msg','your acount deleted succfully');

        }else{

            return redirect('home')->with('msg','rreocrd not dleted there is some propelm');


        }

    }


    public function upload_video($id)
    {

        // $id=Session()->get('uid');
        $record=User::where('user_id',$id)->get();
        $gatagory=DB::table('video_gatagory')->get();
    
        return view('acount.upload_video',compact('record','gatagory'));
    }

    public function send_video_youtube(Request $req,string $id)
    {
        $data=$req->validate([
    
            'video_name'=>'required',
            'video_title'=>'required|max:100',

      ]);
      
        $video="video".time().".".$req->video_name->extension();
        $req->video_name->move(public_path('video'),$video);

        $add_video=DB::table('your_video')
        ->insert([
        'acount_id'=>$id,
        'gatagory_join_id'=>$req->gatagory_join_id,
        'video_name'=>$video,
        'video_title'=>$req->video_title,
     ]);

     if($add_video)
     {
            // return view('acount.upload_video',['add'=>'video send succfully']); 
            // return redirect('home')->with('msg','video uplades');
            return redirect('home')->with('msg','video upladed suucfully');



     }

    }

    public function update_video_id($id)
    {

        $seletect=DB::table('video_view')->where('video_id',$id)->get();


        return view('acount.video_update',compact('seletect'));



    //     $add_video=DB::table('your_video')
    //     ->insert([
    //     'acount_id'=>$id,
    //     'gatagory_join_id'=>$req->gatagory_join_id,
    //     'video_name'=>$video,
    //     'video_title'=>$req->video_title,
    //  ]);
    }

    public function update_video_fun(Request $req,string $id){
        $data=$req->validate([
    
            'video_name'=>'required',
            'video_title'=>'required|max:100',
            'gatagory_join_id'=>'required',
     

      ]);
      
        $video="video".time().".".$req->video_name->extension();
        $req->video_name->move(public_path('video'),$video);

        $update=DB::table('your_video')->where('video_id',$id)
        ->update([
        'gatagory_join_id'=>$req->gatagory_join_id,
        'video_name'=>$video,
        'video_title'=>$req->video_title,
     ]);

     if($update)
     {
        return redirect('home')->with('update_video','video update succfully');


     }

    }
    public function delete_my_video($id)
    {
        $record=DB::table('your_video')->where('video_id',$id)->delete();
        if($record)
        return redirect('home')->with('delted_video','video delted succfully');

    }
    public function view_video_fun($id){

         
        $video=DB::table('your_video')->where('video_id',$id)->get();

        return view('acount.view_video_user',compact('video'));


    }



    public function view_your_video($id){

        // $record=User::where('user_id',$id)->get();
        $record=DB::table('video_view')->where('acount_id',$id)->paginate(4);

        return view('acount.user_table',compact('record'));


    


    }


    public function logout(Request $req)
    {
       $req->session()->forget('uid');
       return redirect('login')->with('msg','succfully logot');


    }


     
     
}

