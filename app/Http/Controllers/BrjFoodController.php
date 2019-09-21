<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrjFoodController extends Controller
{

    public function _signUp(Request $request){
        $name=$request->input("name");
        $phone=$request->input("phone");
        $password=$request->input("password");

        $isRepeated=DB::table("tbl_user")->where("phone","=",$phone)->get()->count();

        if($isRepeated==0){
            DB::table("tbl_user")->insert([
                "name"=>$name,
                "phone"=>$phone,
                "password"=>$password
            ]);

            return "1";
        }else{
            return "0";
        }
    }

    public function _logIn(Request $request){
        $phone=$request->input("phone");
        $password=$request->input("password");

        $toExist=DB::table("tbl_user")->where([["phone","=",$phone],["password","=",$password]])->get()->count();

        return $toExist;
    }

    public function _getResturanData(){

      return  DB::table("tbl_resturan")->get();
    }

    public function _addResturan(Request $request){
        $name=$request->input("name");
        $phone=$request->input("phone");
        $password=$request->input("password");
        $banner=$request->input("banner");
        $address=$request->input("address");

        DB::table("tbl_resturan")->where([["phone","=",$phone],["password","=",$password]])->update(
            [
                "name"=>$name,
                "banner"=>$banner,
                "address"=>$address
            ]
        );
    }

    public  function _getFoodData(){
        return DB::table("tbl_food")->get();
    }

    public function _addFood(Request $request){
        $resturan_id=$request->input("resturan_id");

        $name=$request->input("name");
        $description=$request->input("description");
        $priceFood=$request->input("priceFood");
        $groupFood=$request->input("groupFood");
        $off=$request->input("off");
        $person=$request->input("person");
        $image=$request->input("image");

         DB::table("tbl_food")->insert([
            "resturan_id"=>$resturan_id,
            "name"=>$name,
            "description"=>$description,
            "priceFood"=>$priceFood,
            "groupFood"=>$groupFood,
            "off"=>$off,
            "person"=>$person,
            "image"=>$image,
        ]);
    }

    public function _getFoodByGroup(Request $request){
        $groupFood=$request->input("groupFood");

        return DB::table("tbl_food")->where("groupFood",'=',$groupFood)->get();
    }

    public function _getFoodByName(Request $request){
        $resturan_id=$request->input("resturan_id");

        return DB::table("tbl_food")->where("resturan_id",'=',$resturan_id)->get();

    }

    public function _addOrder(Request $request){
        $resturan_id=$request->input("resturan_id");
        $food_id=$request->input("food_id");
        $user_id=$request->input("user_id");
        $orderCount=$request->input("orderCount");
         DB::table("tbl_order")->insert([
            "resturan_id"=>$resturan_id,
            "food_id"=>$food_id,
            "user_id"=>$user_id,
            "orderCount"=>$orderCount,
        ]);
    }


}
