<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrjFoodController extends Controller
{

    public function _signUp(Request $request)
    {
        $name = $request->input("name");
        $phone = $request->input("phone");
        $password = $request->input("password");

        $isRepeated = DB::table("tbl_user")->where("phone", "=", $phone)->get()->count();

        if ($isRepeated == 0) {
            DB::table("tbl_user")->insert([
                "name" => $name,
                "phone" => $phone,
                "password" => $password
            ]);

            return "1";
        } else {
            return "0";
        }
    }

    public function _logIn(Request $request)
    {
        $phone = $request->input("phone");
        $password = $request->input("password");

        $toExist = DB::table("tbl_user")->where([["phone", "=", $phone], ["password", "=", $password]])->get()->count();

        return $toExist;
    }

    public function _getResturanData()
    {
        return DB::table("tbl_resturan")
            ->where("isActive", '=', 1)
            ->orderByDesc("rate")
            ->get();
    }

    public function _addResturan(Request $request)
    {
        $name = $request->input("name");
        $phone = $request->input("phone");
        $password = $request->input("password");
        $banner = $request->input("banner");
        $address = $request->input("address");
        $bannerLocation = "D:/pEROzie/food/images/" . $banner;


        DB::table("tbl_resturan")->where([["phone", "=", $phone], ["password", "=", $password]])->update(
            [
                "name" => $name,
                "banner" => $bannerLocation,
                "address" => $address
            ]
        );
    }

    public function _getFoodData()
    {
        return DB::table("tbl_food")
            ->join('tbl_resturan', "tbl_food.resturan_id", '=', 'tbl_resturan.id')
            ->where("tbl_resturan.isActive", '=', 1)
            ->select([
                "tbl_food.id",
                "tbl_food.resturan_id",
                "tbl_food.name",
                "tbl_resturan.name as resturanName",
                "tbl_food.description",
                "tbl_food.priceFood",
                "tbl_food.groupFood",
                "tbl_food.off",
                "tbl_food.rate",
                "tbl_food.image",
                "tbl_food.person",
            ])
            ->get();
    }

    public function _addFood(Request $request)
    {
        $resturan_id = $request->input("resturan_id");
        $name = $request->input("nameFood");
        $description = $request->input("descFood");
        $priceFood = $request->input("priceFood");
        $groupFood = $request->input("groupFood");
        $capacityFood = $request->input("capacityFood");
        $off = $request->input("offFood");
        $person = $request->input("person");
        $image = $request->input("imageName");
        $dir = "http://sobhanm28.ir/brj_food/storage/app/FoodImage/" . $name;

        DB::table("tbl_food")->insert([
            "resturan_id" => $resturan_id,
            "name" => $name,
            "description" => $description,
            "priceFood" => $priceFood,
            "groupFood" => $groupFood,
            "off" => $off,
            "person" => $person,
            "image" => $dir,
            "capacityFood" => $capacityFood,
        ]);

    }

    public function _deleteFood(Request $request)
    {
        $food_id = $request->input("food_id");
        $resturan_id = $request->input("resturan_id");

        DB::table("tbl_food")->where([[
            "id", '=', $food_id
        ], [
            "resturan_id", '=', $resturan_id
        ]])->delete();
    }

    public function _insertImage(Request $request)
    {
        $name = $request->input("imageName");
        if ($request->hasFile("imageFood")) {
            $imageFile = $request->file("imageFood");
            $imageFile->move(storage_path('/app/foodImage'), $name);

        }
    }

    public function _getFoodByGroup(Request $request)
    {
        $groupFood = $request->input("groupFood");

        return DB::table("tbl_food")
            ->join('tbl_resturan', "tbl_food.resturan_id", '=', 'tbl_resturan.id')
            ->where([["tbl_food.groupFood", '=', $groupFood], ["tbl_resturan.isActive", '=', 1]])
            ->select([
                "tbl_food.id",
                "tbl_food.resturan_id",
                "tbl_food.name",
                "tbl_resturan.name as resturanName",
                "tbl_food.description",
                "tbl_food.priceFood",
                "tbl_food.groupFood",
                "tbl_food.off",
                "tbl_food.rate",
                "tbl_food.image",
                "tbl_food.person",
            ])
            ->get();
    }

    public function _getFoodByName(Request $request)
    {
        $resturan_id = $request->input("resturan_id");

        return DB::table("tbl_food")
            ->where("resturan_id", "=", $resturan_id)
            ->join('tbl_resturan', "tbl_food.resturan_id", '=', 'tbl_resturan.id')
            ->select([
                "tbl_food.id",
                "tbl_food.resturan_id",
                "tbl_food.name",
                "tbl_resturan.name as resturanName",
                "tbl_food.description",
                "tbl_food.priceFood",
                "tbl_food.groupFood",
                "tbl_food.off",
                "tbl_food.rate",
                "tbl_food.image",
                "tbl_food.person",
            ])
            ->get();

    }

    public function _resturanLogIn(Request $request){
        $phone=$request->input("phone");
        $password=$request->input("password");

        $data= DB::table("tbl_resturan")
            ->where([["phone","=",$phone],["password",'=',$password]])
            ->get();


       return response()->json(
           [
               "res"=>$data->count(),
               "data"=>$data
           ]
       );
    }

    public function _editFood(Request $request)
    {
        $resturan_id = $request->input("resturan_id");
        $food_id = $request->input("food_id");
        $nameFood = $request->input("nameFood");
        $descFood = $request->input("descFood");
        $priceFood = (int)$request->input("priceFood");
        $capacityFood = (int)$request->input("capacityFood");
        $offFood = (int)$request->input("offFood");
        $person = $request->input("person");
        $groupFood = $request->input("groupFood");
        DB::table("tbl_food")->where([["id", '=', $food_id], ["resturan_id", '=', $resturan_id]])
            ->update(
                [
                    "name" => $nameFood,
                    "description" => $descFood,
                    "priceFood" => $priceFood,
                    "groupFood" => $groupFood,
                    "off" => $offFood,
                    "person" => $person,
                    "capacityFood" => $capacityFood,
                ]
            );


    }

    public function _addFoodImage(Request $request)
    {

        if ($request->hasFile("imageFood")) {
            $name = $request->input("imageName");
            $resturan_id = $request->input("resturan_id");
            $food_id = $request->input("food_id");
            $imageFood = $request->file("imageFood");
            $dir = "http://sobhanm28.ir/brj_food/storage/app/foodImage/" . $name;
            $imageFood->move(storage_path('/app/foodImage'), $name);

            DB::table("tbl_food")->where([["id", '=', $food_id], ["resturan_id", '=', $resturan_id]])
                ->update(
                    [
                        "image" => $dir,

                    ]
                );
        }

    }


    public function _getFoodByResturanId(Request $request)
    {
        $resturan_id = $request->input("resturan_id");
        return DB::table("tbl_food")
            ->join("tbl_resturan", 'tbl_food.resturan_id', '=', 'tbl_resturan.id')
            ->where('tbl_food.resturan_id', '=', $resturan_id)
            ->select([
                "tbl_food.id",
                "tbl_food.resturan_id",
                "tbl_food.name as foodName",
                "tbl_resturan.name as resturanName",
                "tbl_food.description",
                "tbl_food.priceFood",
                "tbl_food.groupFood",
                "tbl_food.off",
                "tbl_food.rate",
                "tbl_food.image",
                "tbl_food.capacityFood",
                "tbl_food.person",
                "tbl_resturan.phone",
                "tbl_resturan.banner",
                "tbl_resturan.totalOrder",
                "tbl_resturan.address",

            ])
            ->get();
    }

    public function _increaseFoodCapacity(Request $request)
    {
        $food_id = $request->input("food_id");
        $resturan_id = $request->input("resturan_id");
        DB::table("tbl_food")->where([["id", '=', $food_id], ["resturan_id", '=', $resturan_id]])->increment("capacityFood");
    }

    public function _decreaseFoodCapacity(Request $request)
    {
        $food_id = $request->input("food_id");
        $resturan_id = $request->input("resturan_id");
        DB::table("tbl_food")->where([["id", '=', $food_id], ["resturan_id", '=', $resturan_id]])->decrement("capacityFood");

    }

    public function _addOrder(Request $request)
    {
        $resturan_id = $request->input("resturan_id");
        $food_id = $request->input("food_id");
        $user_id = $request->input("user_id");
        $orderCount = $request->input("orderCount");
        DB::table("tbl_order")->insert([
            "resturan_id" => $resturan_id,
            "food_id" => $food_id,
            "user_id" => $user_id,
            "orderCount" => $orderCount,
        ]);
    }


}
