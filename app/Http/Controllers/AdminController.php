<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function Admindashboard(){
      return view('admin.index');
    }//end
    
   public function Adminlogin()
   {
    return view('admin.admin_login');
    
   }
    public function Admindestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }//end

    public function Adminprofile()
    {
      $id = Auth::user()->id;
      $data = User::find($id);
      return view('admin.admin_profile',compact('data'));
    }

    public function AdminProfileStore(Request $request)
    {
      $id = Auth::user()->id;
      $data = User::find($id);
      $data->name = $request->name;
      $data->email = $request->email;
      $data->phone = $request->phone;
      $data->address = $request->address;
      
      if($request->hasFile('photo')){
        $filename = $request->photo->getClientOriginalName();
        $request->photo->move(public_path('upload/admin_images'),$filename);
        $data['photo']=$filename;
      }
      $data->save(); 
      $notification = array(
        'message' => 'Admin Profile Updated Successfully',
        'alert-type' => 'success'
    );
      return redirect()->back()->with( $notification );
    
    }
    public function AdminChangePassword()
    {
      
      return view('admin.admin_changepassword');
    }
    public function AdminUpdatePassword(Request $request){
      // Validation 
      $request->validate([
          'old_password' => 'required',
          'new_password' => 'required|confirmed', 
      ]);

      // Match The Old Password
      if (!Hash::check($request->old_password, auth::user()->password)) {
          return back()->with("error", "Old Password Doesn't Match!!");
      }

      // Update The new password 
      User::whereId(auth()->user()->id)->update([
          'password' => Hash::make($request->new_password)

      ]);
      return back()->with("status", " Password Changed Successfully");

  } // End Mehtod 

}
