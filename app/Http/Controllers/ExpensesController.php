<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Vehicle;
use App\FuelEntry;
use App\InsurancePayment;
use App\Service;

use App\Http\Resources\ExpensesResource;
use DB;

class ExpensesController extends Controller
{

    
    public function get_expenses()
    {
        $page = request('page');
        $vehicle_name = request('vehicle_name');
        $min_cost = request('min_cost');
        $max_cost = request('max_cost');
        $min_creation_date = request('min_creation_date');
        $max_creation_date = request('max_creation_date');

        $sort_by = request('sort_by'); // cost or creation_date
        $sort_direction = request('sort_direction');
        

        $limit = 10;
        $skip = (intval($page) - 1 ) * $limit ;

        $time1= time();
        $fuelEntry = FuelEntry::select(DB::raw("vehicle_id,cost,entry_date as createdAt,'fuel' as type"));

        $insurances = InsurancePayment::select(DB::raw("vehicle_id,amount as cost,contract_date as createdAt,'service' as type"));

        $services = Service::select(DB::raw("vehicle_id,total as cost,created_at as createdAt,'insurance' as type"));
        

        $expenses = $fuelEntry->union($insurances)->union($services);

        // ->having('type','service')

        if($vehicle_name!=''){
            $expenses->whereHas('vehicle', function($q) use ($vehicle_name){
                $q->where('name','like','%'.$vehicle_name.'%');
            });
        }    

        $expenses = $expenses->with('vehicle')
        // ->take($limit)->skip($skip)
        ->get()
       // ->chunk(10)
        ;

        
        $time2= time();
        echo ($time2 - $time1);
        return $expenses;

        return ExpensesResource::collection($expenses);


    }
}
