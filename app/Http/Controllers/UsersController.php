<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersController extends Controller{
    public function index(){
        if (isset($_GET['search']) && $_GET['search']!=''){
            $users = User::with(['role','bank','role'])->where('name','like','%'.$_GET['search'].'%')->paginate(10
            );
        }else
        $users = User::with(['roles'])->paginate(10);


        return view('users.users',['users'=>$users]);
    }
    public function show($id){
        $user = User::with(['roles'])->findOrFail($id);
        return view('users.show',['user'=>$user]);
    }
    public function profile(){
        $user = User::with(['roles'])->find(auth()->user()->id);
        return view('users.show',['user'=>$user]);
    }
    public function loginPage(){
        return view('auth.login');
    }
    public function create(){
        $roles = Role::all();
        return view('auth.register',['roles'=>$roles]);
    }
    public function store(){
        $attr = request()->validate(
            [
                'name'=>'required|max:255',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:8|max:256',
            ]
        );
        $attr['password'] = bcrypt($attr['password']);
        
        $user = User::create($attr);
        $user->assignRole(request()->role_id);
        return back()->with(['success'=>"تم إنشاء الحساب بنجاح"]);
        

    }
    public function login(){
        $attr = request()->validate(
            [
            'email'=>'required|email|max:255',
            'password'=>'required|max:255'
            ]   
        );
        //$attr['password'] = bcrypt($attr['password']);
        if(Auth::attempt($attr)){
            return redirect('/home')->with('success');

        }
        return back()->withErrors(['error'=>'خطأ في الايميل او كلمة المرور']);
        }
    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
    public function edit($id){
        $user = User::find($id);
        $roles= Role::all();
        return view('users.update',['user'=>$user,'roles'=>$roles]);
    }
    public function update(User $user,Request $request){
        $this->validate($request,[
            'name'=>'required|max:255',
            'email'=>'required|max:255|email|unique:users,email,'.$user->id,
            'avatar'=>'nullable|max:10000|mimes:jpeg,jpg,png,svg,webp',
        ]);
        $user->update($request->except(['avatar','new_password']));
        if($request->hasFile('avatar'))
            {
                if(File::exists(public_path($user->image))){
                    File::delete(public_path($user->image));
                }
                $filename = time().'.'.$request->avatar->extension();
                $user->image = $request->avatar->move('images/users',$filename);
            }
            if ($request->new_password){
                $user->password=bcrypt($request->new_password);
            }

        $user->save();
        return back()->with(['success'=>'تم التعديل بنجاح']);
    }
    public function destroy($id){
        $user = User::find($id);
        if(File::exists(public_path($user->avatar))){
            File::delete(public_path($user->avatar));
        }
        $user->delete();
        return redirect('/users')->with(['success'=>'تم حذف المستخدم بنجاح']);
    }
    public function changePass(Request $request){
        $this->validate($request,[
           'password'=>'required',
            'new_password'=>'required|min:8'
        ]);
        if(Hash::check($request->password,auth()->user()->password)){
            auth()->user()->password=bcrypt($request->new_password);
            auth()->user()->pass_updated=1;
            auth()->user()->save();
            return back()->with(['success'=>'تم التعديل بنجاح']);
        }else{
            return back()->with(['error'=>'كلمة المرور القديمة خاطئة']);
        }
    }
}