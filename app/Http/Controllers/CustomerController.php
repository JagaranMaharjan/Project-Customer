<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Customer;

class CustomerController extends Controller
{
    protected  $webPageName=[];
    //set default name of web page
    function __construct()
    {
        $this->webPageName['title']="Project Customer";
    }

    function home(){
        $this->webPageName['title']='Project Customer';
        $customerData= (new \App\Customer)->orderBy('id', 'desc')->paginate(3);
        return view('home', compact('customerData'), $this->webPageName);
       // return view('home', $this->webPageName);
    }

    function addUser(Request $request){
        $this->validate(
            $request, [
                'customerName'=>'required|min:3',
                'address'=>'required|min:3',
                'organization'=>'required|min:3',
                'mobile'=>'required|min:3',
                'email'=>'email',
                'image'=>'required|mimes:jpeg,jpg,png,gig'
            ]
        );
        $data['customerName']=$request->customerName;
        $data['address']=$request->address;
        $data['organization']=$request->organization;
        $data['mobile']=$request->mobile;
        $data['email']=$request->email;
        if($request->hasFile('image')){
            $image= $request->file('image');
            $ext=$image->getClientOriginalExtension();
            $imageName=Str::random(18).'.'.$ext;
            $uploadPath = public_path('lib/images/');
            $image->move($uploadPath, $imageName);
            $data['image']=$imageName;
        }
        if((new \App\Customer)->create($data)){
            return redirect()->route('home')->with('success', 'Customer Information Registered Successfully');
        }
    }

    function deleteUser(Request $request){
        //echo 'method to delete user'.$request->user_id;
        //get and set user if from routes
        $userId = $request->cid;
        try {
            if ($this->_deleteImage($userId) && (new \App\Customer)->findOrFail($userId)->delete()) {
                //echo "user deleted";
                return redirect()->route('home')->with('success', 'User Deleted Successfully !!!');
            }
        } catch (\Exception $e) {
            echo $e;
        }
    }

    //method to delete image
    function _deleteImage($id){
        //fetch data of user according to user id first
        $userData = (new \App\Customer)->findOrFail($id);
        //fetch and set user image name from userData
        $imageName = $userData->image;
        //get image path
        $imagePath = public_path('lib/images/'.$imageName);
        //check whether image exists or not
        if(file_exists($imagePath)){
            return unlink($imagePath);
        }
        return true;
    }

    //method to edit user detail
    function editUser(Request $request){
        //new web page name
        $this->webPageName['title']='Edit Customer Info';
        //get user id from http request
        $userId = $request->userId;
        //fetch users data according to user id
        $userData = (new \App\Customer)->findOrFail($userId);
        return view('edit_customer', compact('userData'), $this->webPageName);
    }



    //method to update user edited data
    function  editUserAction(Request $request){
        $this -> validate(
            $request, [
                'customerName'=>'required|min:3',
                'address'=>'required|min:3',
                'organization'=>'required|min:3',
                'mobile'=>'required|min:3',
                'email'=>'email',
                'image'=>'required|mimes:jpeg,jpg,png,gig'
            ]
        );
        $data['customerName']=$request->customerName;
        $data['address']=$request->address;
        $data['organization']=$request->organization;
        $data['mobile']=$request->mobile;
        $data['email']=$request->email;
        //get id
        $id = $request->id;
        //dd($data);//display data
        if($request->hasFile('image')){
            $image= $request->file('image');
            $ext=$image->getClientOriginalExtension();
            $imageName=Str::random(18).'.'.$ext;
            $uploadPath = public_path('lib/images/');
            //delete old image first & upload new image
            if($this->_deleteImage($id) && $image->move($uploadPath, $imageName)){
                $data['image']=$imageName;
            }
        }
        if((new \App\Customer)->where('id', $id)->update($data)){
            //--->echo "users data updated";
            return redirect()->route('home')->with('success', 'Customer Info Updated Successfully !!!');
        }
    }
}