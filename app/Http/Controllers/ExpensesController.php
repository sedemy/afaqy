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
        $page = request('page') ?? 1;
        $vehicle_name = request('vehicle_name');
        $expense_type = request('expense_type');

        $min_cost = request('min_cost');
        $max_cost = request('max_cost');
        $min_creation_date = request('min_creation_date');
        $max_creation_date = request('max_creation_date');

        $sort_by = strtolower(request('sort_by')); // cost or creation_date
        $sort_direction = strtolower(request('sort_direction'));
        

        $limit = 10;
        if($min_cost !='' ||  $max_cost !='' || $min_creation_date!='' || $max_creation_date !=''){
            $limit = 1;
            $page = 1;
        }

        $skip = (intval($page) - 1 ) * $limit ;


        $fuelEntry = DB::table('fuel_entries')->select(DB::raw("vehicle_id,cost,entry_date as createdAt,'fuel' as type"));
        
        $insurances = DB::table('insurance_payments')->select(DB::raw("vehicle_id,amount as cost,contract_date as createdAt,'service' as type"));

        $services = DB::table('services')->select(DB::raw("vehicle_id,total as cost,created_at as createdAt,'insurance' as type"));
        

        $union = $fuelEntry->unionAll($insurances)->unionAll($services);

        $querySql = $union->toSql();

        $expenses = DB::table(DB::raw("($querySql) as union_query"));//->mergeBindings($union);

        $expenses->select(['vehicle_id', 'cost', 'createdAt', 'type','vehicles.name','vehicles.plate_number']);

        $expenses->join('vehicles','vehicles.id','=','union_query.vehicle_id');


        
        if($expense_type !=''){
            $expenses->whereIn('type',@explode(',',$expense_type));
        }

        if($vehicle_name!=''){
            $expenses->where('name','like','%'.$vehicle_name.'%');
        }    

        if($min_cost!=''){
            $expenses->orderBy('cost', 'asc');
        }elseif($max_cost!=''){
            $expenses->orderBy('cost', 'desc');
        }

        if($min_creation_date!=''){
            $expenses->orderBy('createdAt', 'asc');
        }elseif($max_creation_date!=''){
            $expenses->orderBy('createdAt', 'desc');
        }

        if($sort_by == 'cost' || $sort_by == 'creation_date'){
            $sort_direction = $sort_direction == 'desc' ? 'desc':'asc';
            $expenses->orderBy($sort_by, $sort_direction);
        }
        
        $expenses->take($limit)->skip($skip);

        return ExpensesResource::collection($expenses->get());


    }
}
