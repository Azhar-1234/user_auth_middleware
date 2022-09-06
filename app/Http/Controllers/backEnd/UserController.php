<?php

namespace App\Http\Controllers\backEnd;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\User;
class UserController extends Controller
{
    public function view(){
        $data['allData'] = User::all();
        return view('backEnd.user.user-view',$data);
    }
    public function store(Request $request){

        $request->validate([        
    		'name' =>'required',
            'email' => 'required',
            'password' => 'required|unique:users|min:8',      
            'mobile' => 'required|unique:users',      
            'image' => 'required',     
            'role' => 'required',
         ]);

        $data =  new User();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($data->password);
        $data->mobile = $request->mobile;
        $data->status = $request->status;
        $data->role = $request->role;
         if ($request->file('image')) {
            $file = $request->file('image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/'),$filename);
            $data['image'] = $filename;
        }
        
        $result = $data->save();
        Session::flash('msg','User added');
        if($data):
            return redirect()->back()->with('success','inserted sucessfully');
        else:
            return redirect()->back()->with('danger','inserted unsucessfully');
        endif;                           
    }
    public function edit($id){
        $editData = User::find($id);
        $allData = User::all();
        return view('backEnd.user.user-view',compact('editData','allData'));
    }
    public function update(Request $request){        
        $data = User::findOrFail($request->id);
        $request->validate([        
            'name' =>'required',
            'email' => 'required',
            'password' => 'required|min:8|unique:users,password,'.$request->id,      
            'mobile' => 'required|unique:users,mobile,'.$request->id, 
            'role' => 'required'     
         ]);
                $data->name = $request->name;
        $data->email = $request->email;
        $data->password = bcrypt($data->password);
        $data->mobile = $request->mobile;
        $data->status = $request->status;
        $data->role = $request->role;
       if ($request->file('image')) {
          $file = $request->file('image');
          @unlink(public_path('upload/'.$data->image));
          $filename = date('YmdHi').$file->getClientOriginalName();
          $file->move(public_path('upload'),$filename);
          $data['image'] = $filename;
        }
        else{
            unset($data['image']);
        }
          


        $result = $data->save();
        if($result):
            return redirect('view-user')->with('success','updated sucessfully');
        else:
            return redirect()->back()->with('danger','updated unsucessfully');
        endif;              
    }
    public function delete($id){
        $result = User::destroy($id);
        if($result):
            return redirect('view-user')->with('success','deleted sucessfully');
        else:
            return redirect()->back()->with('danger','deleted unsucessfully');
        endif;              

    }
}
