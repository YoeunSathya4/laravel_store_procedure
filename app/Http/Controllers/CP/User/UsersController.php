<?php

namespace App\Http\Controllers\CP\User;

use Auth;
use Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\CamCyber\FileUploadController as FileUpload;
use App\Http\Controllers\CamCyber\FunctionController;
use DB;
use App\Model\User\User as Model;
use App\Model\User\Position;
use App\Model\User\Category;
use App\Model\User\Role as Role;
use App\Model\Setup\Zone as Zone;

class UsersController extends Controller
{
    protected $route;
    public function __construct(){
        $this->route = "cp.user.user";
    }
    function validObj($id=0){
        $data = Model::find($id);
        if(empty($data)){
           echo "Invalide Object"; die;
        }
    }

   public function index(){
        $this->checkPermision($this->route.'.index');
        $data = Model::where(array('visible'=>1))->get();
        $user = DB::select("CALL getuser()"); 
        dd($user);
        if(!empty($data)){
            return view($this->route.'.index', ['route'=>$this->route, 'data'=>$data]);
        }else{
            return view('errors.404');
        }
    }
   
    public function create(){
        return view($this->route.'.create', ['route'=>$this->route]);
    }
    public function store(Request $request) {
        $data = array(
                    'name' =>   $request->input('name'),
                    'phone' =>  $request->input('phone'), 
                    'email' =>  $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'position_id' =>  $request->input('position_id'),
                    'status' =>  $request->input('status')
                );
        Session::flash('invalidData', $data );
        Validator::make(
                        $request->all(), 
                        [
                            'name' => 'required',
                            'phone' => [
                                            'required',
                                            Rule::unique('users')
                                        ],
                            'email' => [
                                            'required',
                                            'email',
                                            Rule::unique('users')
                                        ],
                            'password'         => 'required|min:6|max:18',
                            'confirm_password' => 'required|same:password',
                            'avatar' => [
                                            'required',
                                            'mimes:jpeg,png',
                                            Rule::dimensions()->width(200)->height(165),
                            ],
                        ], 

                        [
                            'email.unique' => 'New new email address :'.$request->input('email').' can not be used. It has already been taken.',
                            'avatar.dimensions' => 'Please provide valide image dimensions 200x165.',
                        ])->validate();
        
        
        $avatar = FileUpload::uploadFile($request, 'avatar', 'uploads/user');
        if($avatar != ""){
            $data['avatar'] = $avatar; 
        }
        $id=Model::insertGetId($data);
        Session::flash('msg', 'Data has been Created!');
        return redirect(route($this->route.'.edit', $id));
    }

    public function edit($id = 0){
        $this->validObj($id);
        $data = Model::find($id);
        return view($this->route.'.edit', ['route'=>$this->route, 'id'=>$id, 'data'=>$data]);
    }

    public function update(Request $request){
        $id = $request->input('id');
        Validator::make(
                        $request->all(), 
                        [
                            'name' => 'required',
                            
                            'phone' => [
                                            'required',
                                            Rule::unique('users')->ignore($id)
                                        ],
                            'email' => [
                                            'required',
                                            'email',
                                            Rule::unique('users')->ignore($id)
                                        ],
                            'avatar' => [
                                            'sometimes',
                                            'required',
                                            'mimes:jpeg,png',
                                            Rule::dimensions()->width(200)->height(165),
                            ],
                        ],
                        [
                            'email.unique' => 'New new email address :'.$request->input('email').' can not be used. It has already been taken.',
                            'avatar.dimensions' => 'Please provide valide image dimensions 200x165.',
                        ])->validate();

        
        $data = array(
                    'name' =>   $request->input('name'),
                    'phone' =>  $request->input('phone'), 
                    'email' =>  $request->input('email'),
                    'position_id' =>  $request->input('position_id'),
                    'status' =>  $request->input('status')
                );
        
        $avatar = FileUpload::uploadFile($request, 'avatar', 'uploads/user');
        if($avatar != ""){
            $data['avatar'] = $avatar; 
        }
        //echo $picture; die;
        Model::where('id', $id)->update($data);
        Session::flash('msg', 'Data has been updated!' );
        return redirect()->back();
    }

    public function password(Request $request){
        $data = array(
                    'password' => bcrypt($request->input('password'))
                );
        $id = $request->input('id');
         Model::where('id', $id)->update($data);
        return response()->json([
            'status' => 'success',
            'msg' => 'Password has been updated.'
        ]);
    }

    function status(Request $request){
      $id   = $request->input('id');
      $data = array('status' => $request->input('status'));
      Model::where('id', $id)->update($data);
      return response()->json([
          'status' => 'success',
          'msg' => 'User status has been updated.'
      ]);
    }
   
    public function trash($id){
        Model::where('id', $id)->update(['deleter_id' => Auth::id()]);
        Model::where('id', $id)->delete();
        Session::flash('msg', 'Data has been delete!' );
        return response()->json([
            'status' => 'success',
            'msg' => 'User has been deleted'
        ]);
    }

    public function logs($id=0){
        $this->validObj($id);
        
        $dataLog = Model::find($id)->logs();
        $limit=intval(isset($_GET['limit'])?$_GET['limit']:10); 
        $from=isset($_GET['from'])?$_GET['from']:"";
        $till=isset($_GET['till'])?$_GET['till']:"";

        if($limit <= 0 || $limit > 100){
            $limit = 10;
        }

        $appends=array('limit'=>$limit);
       
        if(FunctionController::isValidDate($from)){
            if(FunctionController::isValidDate($till)){
                $appends['from'] = $from;
                $appends['till'] = $till;

                $from .=" 00:00:00";
                $till .=" 23:59:59";

                $dataLog = $dataLog->whereBetween('created_at', [$from, $till]);
            }
        }
       
        $logs= $dataLog->orderBy('created_at', 'DESC')->paginate($limit);
        return view($this->route.'.logs', ['route'=>$this->route, 'id'=>$id, 'data'=>$logs, 'appends'=>$appends]);
    }

    public function updatePassword(Request $request){
        $data = array(
                    'password' => bcrypt($request->input('password'))
                );
        $id = $request->input('id');
         Model::where('id', $id)->update($data);
        return response()->json([
            'status' => 'success',
            'msg' => 'Password has been updated.'
        ]);
    }

    function updateStatus(Request $request){
      $id   = $request->input('id');
      $data = array('status' => $request->input('status'));
      Model::where('id', $id)->update($data);
      return response()->json([
          'status' => 'success',
          'msg' => 'User status has been updated.'
      ]);
    }

    public function permision($id=0){
        $categories = Category::get();
        $data = Model::find($id)->userPermisions;
        return view($this->route.'.permision', ['route'=>$this->route, 'id'=>$id, 'data'=>$data, 'categories'=>$categories]);
    }
    public function checkPermisions($id=0){
        $user_id        = $_GET['user_id'];
        $permision_id   = $_GET['permision_id'];
        $now            = date('Y-m-d H:i:s');
        $assigner_id    = Auth::id();

        $user = Model::find($user_id);
        $dataPermision = $user->userPermisions()->select('permision_id')->get(); 

        $is_permision_existed = 0;
        foreach($dataPermision as $row){
            if($row->permision_id == $permision_id){
                $is_permision_existed = 1;
            }
        }
       
        if($is_permision_existed == 1){
            $user->userPermisions()->where('permision_id', $permision_id)->delete();
            return response()->json([
                  'status' => 'success',
                  'msg' => 'Permision has been removed.'
            ]);
        }else{
            $data_permision=array(
                'user_id' => $user_id,
                'permision_id' => $permision_id,
                'creator_id' => $assigner_id, 
                'updater_id' => $assigner_id,
                'created_at' => $now, 
                'updated_at' => $now
                );
            $user->userPermisions()->insert($data_permision);
             return response()->json([
                  'status' => 'success',
                  'msg' => 'Permision has been added.'
              ]);
        }
    }

    public function zone($id=0){
        $zones = Zone::get();
        $data = Model::find($id)->zoneUsers;
        //dd($data);
        return view($this->route.'.zone', ['route'=>$this->route, 'id'=>$id, 'data'=>$data,'zones'=>$zones]);
    }
    public function checkZones($id=0){
        $user_id        = $_GET['user_id'];
        $zone_id   = $_GET['zone_id'];
        $now            = date('Y-m-d H:i:s');
        $assigner_id    = Auth::id();

        $user = Model::find($user_id);
        $dataZone = $user->zoneUsers()->select('zone_id')->get(); 

        $is_zone_existed = 0;
        foreach($dataZone as $row){
            if($row->zone_id == $zone_id){
                $is_zone_existed = 1;
            }
        }
       
        if($is_zone_existed == 1){
            $user->zoneUsers()->where('zone_id', $zone_id)->delete();
            return response()->json([
                  'status' => 'success',
                  'msg' => 'Zone has been removed.'
            ]);
        }else{
            $data_zone=array(
                'user_id' => $user_id,
                'zone_id' => $zone_id,
                'creator_id' => $assigner_id, 
                'updater_id' => $assigner_id,
                'created_at' => $now, 
                'updated_at' => $now
                );
            $user->zoneUsers()->insert($data_zone);
             return response()->json([
                  'status' => 'success',
                  'msg' => 'Zone has been added.'
              ]);
        }
    }

}
