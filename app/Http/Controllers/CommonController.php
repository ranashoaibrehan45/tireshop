<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Metro;
use App\Models\Vehicle;
use App\Models\UsState;
use App\Models\Resource;
use App\Models\Company;
use App\Models\SubCategory;
use App\Models\Experience;

class CommonController extends Controller
{
    public function getMetros(Request $request)
    {
    	$result = Metro::orderBy('name', 'asc')->get();
    	return request()->json(200, $result);
    }

    public function getStates()
	{
		$result = UsState::select('state','code')
					->distinct()
					->where('status', 1)
					->orderBy('state')
					->get();

		return request()->json(200, $result);
	}

	public function getVehicles()
	{
		$result = Vehicle::orderBy('name')->get();
		return request()->json(200, $result);
	}

	public function getResources()
	{
		$result = Resource::orderBy('id')->get();
		return request()->json(200, $result);
	}

	/* Get all categories */
	public function getCompanies()
	{
		$result = Company::orderBy('name')->get();
		return request()->json(200, $result);
	}

	/* Get all categories */
	public function getSubCategories($categoryId)
	{
		$result = SubCategory::where('category_id',$categoryId)
							->orderBy('name')
							->get();
							
		return request()->json(200, $result);
	}

	/* Get all experience list */
	public function getExperience()
	{
		$result = Experience::orderBy('name')->get()->keyBy('id');
		return request()->json(200, $result);
	}

}// end of class
