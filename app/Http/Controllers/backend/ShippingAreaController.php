<?php

namespace App\Http\Controllers\backend;

use Carbon\Carbon;
use App\Models\Division;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\State;

class ShippingAreaController extends Controller
{
    /* Divisions */
    public function viewDivisions()
    {
        $divisions = Division::latest()->get();
        return view('admin.shipping.division.index', compact('divisions'));
    }

    public function storeDivision(Request $request)
    {
        $request = $request->merge(['name' => trim(strip_tags($request->name))]);
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Division::insert([
            'name' => strtoupper($request->name),
            'created_at' => Carbon::now(),
        ]);
        return redirect()->back()->with('success', 'Division added successfully');
    }

    public function editDivision($id)
    {
        $division = Division::find($id);
        if ($division) {
            return view('admin.shipping.division.edit', compact('division'));
        } else {
            return redirect()->route('admin.show.division')->with('fail', 'There is no such division...');
        }
    }

    public function updateDivision($id, Request $request)
    {
        $division = Division::find($id);
        if ($division) {
            $request = $request->merge(['name' => trim(strip_tags($request->name))]);
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
            $division->update([
                'name' => strtoupper($request->name),
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'The division was successfully updated');
        } else {
            return redirect()->back()->with('fail', 'There is no such division...');
        }
    }

    public function deleteDivision($id)
    {
        $division = Division::find($id);
        if ($division) {
            $division->delete();
            $districts = District::where('division_id', $id)->get();
            if ($districts) {
                foreach ($districts as $district) {
                    $district->delete();
                }
            }
            $states = State::where('division_id', $id)->get();
            if ($states) {
                foreach ($states as $state) {
                    $state->delete();
                }
            }
            return redirect()->back()->with('success', 'The division was successfully deleted');
        } else {
            return redirect()->back()->with('fail', 'There is no such division...');
        }
    }

    /* Districts */

    public function viewDistricts()
    {
        $districts = District::latest()->with('division')->get();
        $divisions = Division::get();
        return view('admin.shipping.district.index', compact('districts', 'divisions'));
    }

    public function storeDistrict(Request $request)
    {
        $request = $request->merge(['name' => trim(strip_tags($request->name))]);
        $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'required',
        ]);
        District::insert([
            'name' => strtoupper($request->name),
            'division_id' => $request->division,
            'created_at' => Carbon::now(),
        ]);
        return redirect()->back()->with('success', 'District added successfully');
    }

    public function editDistrict($id)
    {
        $district = District::find($id);
        $divisions = Division::where('id', '!=', $district->division_id)->get();
        if ($district) {
            return view('admin.shipping.district.edit', compact('district', 'divisions'));
        } else {
            return redirect()->route('admin.show.district')->with('fail', 'There is no such district...');
        }
    }

    public function updateDistrict($id, Request $request)
    {
        $district = District::find($id);
        if ($district) {
            $request = $request->merge(['name' => trim(strip_tags($request->name))]);
            $request->validate([
                'name' => 'required|string|max:255',
                'division' => 'required',
            ]);
            $district->update([
                'name' => strtoupper($request->name),
                'division_id' => $request->division,
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'The district was successfully updated');
        } else {
            return redirect()->back()->with('fail', 'There is no such district...');
        }
    }

    public function deleteDistrict($id)
    {
        $district = District::find($id);
        if ($district) {
            $district->delete();
            $states = State::where('district_id', $id)->get();
            if ($states) {
                foreach ($states as $state) {
                    $state->delete();
                }
            }
            return redirect()->back()->with('success', 'The district was successfully deleted');
        } else {
            return redirect()->back()->with('fail', 'There is no such district...');
        }
    }

    /* States */

    public function viewStates()
    {
        $states = State::orderBy('name', 'asc')->with(['division', 'district'])->get();
        $divisions = Division::get();
        //$districts = District::get(); 'districts', 
        return view('admin.shipping.state.index', compact('divisions', 'states'));
    }

    public function storeState(Request $request)
    {
        $request = $request->merge(['name' => trim(strip_tags($request->name))]);
        $request->validate([
            'name' => 'required|string|max:255',
            'division' => 'required',
            'district' => 'required',
        ]);
        State::insert([
            'name' => strtoupper($request->name),
            'division_id' => $request->division,
            'district_id' => $request->district,
            'created_at' => Carbon::now(),
        ]);
        return redirect()->back()->with('success', 'State added successfully');
    }

    public function editState($id)
    {
        $state = State::find($id);
        $divisions = Division::where('id', '!=', $state->division_id)->get();
        $districts = District::where('id', '!=', $state->district_id)->where('division_id', $state->division_id)->get();
        if ($state) {
            return view('admin.shipping.state.edit', compact('districts', 'divisions', 'state'));
        } else {
            return redirect()->route('admin.show.state')->with('fail', 'There is no such state...');
        }
    }

    public function updateState($id, Request $request)
    {
        $state = State::find($id);
        if ($state) {
            $request = $request->merge(['name' => trim(strip_tags($request->name))]);
            $request->validate([
                'name' => 'required|string|max:255',
                'division' => 'required',
                'district' => 'required',
            ]);
            $state->update([
                'name' => strtoupper($request->name),
                'division_id' => $request->division,
                'district_id' => $request->district,
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->back()->with('success', 'The state was successfully updated');
        } else {
            return redirect()->back()->with('fail', 'There is no such state...');
        }
    }

    public function deleteState($id)
    {
        $state = State::find($id);
        if ($state) {
            $state->delete();
            return redirect()->back()->with('success', 'The state was successfully deleted');
        } else {
            return redirect()->back()->with('fail', 'There is no such state...');
        }
    }

    public function getDistrict($id)
    {
        $distr = District::where('division_id', $id)->get();
        return json_encode($distr);
    }
}
