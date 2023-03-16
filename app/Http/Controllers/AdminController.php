<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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
}
