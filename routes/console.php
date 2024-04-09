<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $response = Http::get("https://randomuser.me/api/?results=20")->json()["results"];
    $arrUser = [];
    $genderCount = [
        "male" => 0,
        "female" => 0
    ];
    foreach($response as $index => $value) {
        $arrUser[$index] = [
            "Gender" => $value["gender"],
            "Name" => json_encode($value["name"]),
            "Location" => json_encode($value["location"]),
            "age" => $value["dob"]["age"],
            "uuid" => $value["login"]["uuid"]
        ];
        $genderCount[$value["gender"]] = $genderCount[$value["gender"]] + 1;
    }
    try {
        DB::transaction(function () use($arrUser) {
            User::upsert($arrUser, uniqueBy: ['uuid'],update: ["Gender","Name","Location","age"]);
            DB::commit();
        });
        Redis::set("male", $genderCount["male"]);
        Redis::set("female", $genderCount["female"]);

    }catch(Exception $e) {
        DB::rollBack();
        Log::error($e);
    }
})->everyFiveSeconds();
