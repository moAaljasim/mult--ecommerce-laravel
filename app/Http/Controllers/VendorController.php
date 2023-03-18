<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Illuminate\Http\Request;

class VendorController extends Controller
{
    
    public function Vendordashboard(){
        return view('vendor.index');
      }
      //end
         
      public function Vendorlogin()
     {
     return view('Vendor.Vendor_login');
      
     }
     public function Vendordestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/vendor/login');
    }//end
    public function Vendorprofile()
    {
      $id = Auth::user()->id;
      $data = User::find($id);
      return view('vendor.vendor_profile',compact('data'));
    }//end

    
    public function VendorProfileStore(Request $request)
    {
      $id = Auth::user()->id;
      $data = User::find($id);
      $data->name = $request->name;
      $data->email = $request->email;
      $data->phone = $request->phone;
      $data->address = $request->address;
      $data->vendor_join = $request->vendor_join;
      $data->vendor_short_info = $request->vendor_short_info;
      
      if($request->hasFile('photo')){
        $filename = $request->photo->getClientOriginalName();
        $request->photo->move(public_path('upload/vendor_images'),$filename);
        $data['photo']=$filename;
      }
      $data->save(); 
      $notification = array(
        'message' => 'vendor Profile Updated Successfully',
        'alert-type' => 'success'
    );
      return redirect()->back()->with( $notification );
    
    }

}
