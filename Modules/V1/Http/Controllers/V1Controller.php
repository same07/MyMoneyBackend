<?php

namespace Modules\V1\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\V1\Entities\Category;
use Modules\V1\Entities\Transactions;

use Carbon\Carbon;

class V1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
     public function revenueLoad(Request $request){
        $input = $request->input();

        $post_data = isset($input['data']) ? $input['data'] : array();

        $offset = isset($post_data['offset']) ? $post_data['offset'] - 1 : 0;
        $limit = 10;
        $keyword = isset($post_data['keyword']) ? $post_data['keyword'] : '';

        $dt = Transactions::whereNull('deleted_at')->where('category_type','Revenue');
        if($keyword != ""){
            $dt->where(function($query) use ($keyword){
                $query->orWhere('description','LIKE','%'.$keyword.'%');
            });
        }
        $r = array();
        $data = $dt->offset($offset * $limit)->limit($limit)->with('category')->get();
        if(count($data) > 0){
            foreach($data as $v){
                $v->image = isset($v->image) ? asset('image/'.$v->image) : '';
                $r[] = $v;
            }
        }
        $return = array(
            "status" => 200,
            "error" => false,
            "msg" => "",
            "data" => $r
        );
        return response()->json($return);
     }

     public function expensesLoad(Request $request){
        $input = $request->input();

        $post_data = isset($input['data']) ? $input['data'] : array();

        $offset = isset($post_data['offset']) ? $post_data['offset'] - 1 : 0;
        $limit = 10;
        $keyword = isset($post_data['keyword']) ? $post_data['keyword'] : '';

        $dt = Transactions::whereNull('deleted_at')->where('category_type','Expenses');
        if($keyword != ""){
            $dt->where(function($query) use ($keyword){
                $query->orWhere('description','LIKE','%'.$keyword.'%');
            });
        }
        $r = array();
        $data = $dt->offset($offset * $limit)->limit($limit)->with('category')->get();
        if(count($data) > 0){
            foreach($data as $v){
                $v->image = isset($v->image) ? asset('image/'.$v->image) : '';
                $r[] = $v;
            }
        }
        $return = array(
            "status" => 200,
            "error" => false,
            "msg" => "",
            "data" => $r
        );
        return response()->json($return);
     }

     public function TransactionsView($id){
        $dt = Transactions::find($id);
        $category = Category::find($dt->category_id);
        $dt->category_name = $category->name;
        $dt->image_path = isset($dt->image) ? $dt->image : null;
        $dt->image = isset($dt->image)  ? asset('image/'.$dt->image) : null;
        $return = array(
            "status" => 200,
            "error" => false,
            "msg" => "",
            "data" => $dt
        );
        return response()->json($return);
     }

     public function TransactionsDelete($id){
        $dt = Transactions::find($id);
        $dt->delete();
        $return = array(
            "status" => 200,
            "error" => false,
            "msg" => "Transaksi berhasil dihapus",
            "data" => $dt
        );
        return response()->json($return);
     }

     public function transactionStore(Request $request){
        $input = $request->input();
        $post_data = isset($input['data']) ? $input['data'] : array();
        $id = isset($post_data['id']) ? $post_data['id'] : null;
        if(isset($id)){
            $dt = Transactions::find($id);
        }else{
            $dt = new Transactions;
        }
        $dt->amount = isset($post_data['amount']) ? $post_data['amount'] : 0;
        $dt->date = isset($post_data['date']) ? Carbon::parse($post_data['date'])->format("Y-m-d") : Carbon::now()->format("Y-m-d");
        $dt->category_type = isset($post_data['category_type']) ? $post_data['category_type'] : null;
        $dt->category_id = isset($post_data['category_id']) ? $post_data['category_id'] : null;
        $dt->description = isset($post_data['description']) ? $post_data['description'] : null;
        $dt->image = isset($post_data['image_path'])  ? $post_data['image_path'] : null;
        $dt->wallet_id = isset($post_data['wallet_id']) ? $post_data['wallet_id'] : 1;

        $dt->save();

        $return = array(
            "status" => 200,
            "error" => false,
            "msg" => "Berhasil menyimpan transaksi"
        );
        return response()->json($return);
     }

     public function categoryRevenueLoad(Request $request){
        $input = $request->input();

        $post_data = isset($input['data']) ? $input['data'] : array();

        $offset = isset($post_data['offset']) ? $post_data['offset'] - 1 : 0;
        $limit = 10;
        $keyword = isset($post_data['keyword']) ? $post_data['keyword'] : '';

        $dt = Category::whereNull('deleted_at')->where('category_type','Revenue');
        if($keyword != ""){
            $dt->where(function($query) use ($keyword){
                $query->orWhere('name','LIKE','%'.$keyword.'%');
            });
        }
        $r = array();
        $data = $dt->offset($offset * $limit)->limit($limit)->get();
        if(count($data) > 0){
            foreach($data as $v){
                $r[] = $v;
            }
        }
        $return = array(
            "status" => 200,
            "error" => false,
            "msg" => "",
            "data" => $r
        );
        return response()->json($return);
     }

     public function categoryExpensesLoad(Request $request){
        $input = $request->input();

        $post_data = isset($input['data']) ? $input['data'] : array();

        $offset = isset($post_data['offset']) ? $post_data['offset'] - 1 : 0;
        $limit = 10;
        $keyword = isset($post_data['keyword']) ? $post_data['keyword'] : '';

        $dt = Transactions::whereNull('deleted_at')->where('category_type','Expenses');
        if($keyword != ""){
            $dt->where(function($query) use ($keyword){
                $query->orWhere('name','LIKE','%'.$keyword.'%');
            });
        }
        $r = array();
        $data = $dt->offset($offset * $limit)->limit($limit)->get();
        if(count($data) > 0){
            foreach($data as $v){
                $r[] = $v;
            }
        }
        $return = array(
            "status" => 200,
            "error" => false,
            "msg" => "",
            "data" => $r
        );
        return response()->json($return);
     }

     public function categoryLoad(Request $request){
        $input = $request->input();

        $post_data = isset($input['data']) ? $input['data'] : array();

        $offset = isset($post_data['offset']) ? $post_data['offset'] - 1 : 0;
        $limit = 10;
        $keyword = isset($post_data['keyword']) ? $post_data['keyword'] : '';
        $category_type = isset($post_data['category_type']) ? $post_data['category_type'] : null;
        $dt = Category::whereNull('deleted_at');
        if(isset($category_type)){
            $dt->where('category_type',$category_type);
        }
        if($keyword != ""){
            $dt->where(function($query) use ($keyword){
                $query->orWhere('name','LIKE','%'.$keyword.'%');
            });
        }
        $r = array();
        $data = $dt->offset($offset * $limit)->limit($limit)->get();
        if(count($data) > 0){
            foreach($data as $v){
                $r[] = $v;
            }
        }
        $return = array(
            "status" => 200,
            "error" => false,
            "msg" => "",
            "data" => $r
        );
        return response()->json($return);
     }

     public function categoryGet($id){
        $dt = Category::find($id);
        $return = array(
            "status" => 200,
            "error" => false,
            "data" => $dt
        );
        return response()->json($return);
     }

     public function categoryDelete($id){
        $dt = Category::find($id);
        $dt->deleted_at = Carbon::now()->format("Y-m-d H:i:s");
        $dt->save();
        $return = array(
            "status" => 200,
            "error" => false,
            "msg" => "Category berhasil dihapus",
        );
        return response()->json($return);
     }

     public function categoryStore(Request $request){
         $input = $request->input();
         $post_data = isset($input['data']) ? $input['data'] : array();
         
         $dt = new Category;
         $dt->category_type = isset($post_data['category_type']) ? $post_data['category_type'] : null;
         $dt->name = isset($post_data['name']) ? $post_data['name'] : null;

         $dt->save();

         $return = array(
            "status" => 200,
            "error" => false,
            "msg" => "Category berhasil ditambahkan",
        );
        return response()->json($return);
     }
     /*test*/
     public function uploadImage(Request $request){
        if ($request->hasFile('file')){
            $file = $request->file("file");
            $id =  time();
            $filename = $id.'.'.$file->getClientOriginalExtension();
            $filePath = $request->file("file")->storeAs('',$filename,"public");

            $return['data'] = $filename;
            $return['msg'] = "success";
            $return['error'] = false;
            $return['status'] = 200;

        }else{
            $return['status'] = 500;
            $return['msg'] = "file is required";
            $return['error'] = true;    
            $return['error_msg'] = 'file is required';
        }
        return response()->json($return);
     }
}
