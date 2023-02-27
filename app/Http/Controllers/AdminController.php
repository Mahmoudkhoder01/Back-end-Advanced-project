<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    public function getAll(Request $req){
        $admin = Admin::get();
        return response()->json([
           "message" => $admin
        ]);
     }
     public function getById(Request $req, $id){
        $admin = Admin::where("id", $id)->get();
        return response()->json([
           "message" => $admin
        ]);
     }
     public function addAdmin(Request $req){
        $admin = new Admin();
        $username = $req->input("username");
        $email = $req->input("email");
        $password = hash::make($req->input('password'));
        $admin->username = $username;
        $admin->email = $email;
        $admin->password = $password;
        $admin->save();
        return response()->json([
           "message" => "Success"
        ]);
     }
  
     public function deleteAdmin(Request $req, $id){
           $admin = Admin::find($id);
           $admin->delete();
           return response()->json([
               'message' => 'Admin deleted Successfully!',
           ]);
       }
       public function editAdmin(Request $req, $id){
        $admin =  Admin::find($id);
        $inputs= $req->all();
        $admin->update($inputs);
        return response()->json([
            'message' => 'Admin edited successfully!',
            'Admin' => $admin,
        ]);
    }
}
