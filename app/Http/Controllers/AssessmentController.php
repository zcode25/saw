<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Assessment;
use App\Criteria;
use App\Employe;
use App\Decision;
Use Alert;
use PDF;
class AssessmentController extends Controller
{

    public function index() {
        $decisions = Decision::orderBy('decision_date', 'desc')->get();
        return view('dashboard.admin.assessment.index', [
            'decisions' => $decisions
        ]);
    }

    public function decision(Request $request){
        request()->validate([
            'decision_name'=>['required'],
            'decision_date'=>['required'],
        ]);
        $decision = Decision::create([
            'decision_name'=>request('decision_name'),
            'decision_date'=>request('decision_date'),
        ]);
        return redirect()->route('assessment')->withSuccess('Add New Decision Success');
    }

    public function saw($id){

        $criterias = Criteria::orderBy('criteria_code','Asc')->with('sub_criteria')->get();
        $criteria_filtered = Criteria::orderBy('criteria_code','Asc')->has('assessment')->with('sub_criteria')->get();
        $employes = Employe::orderBy('id','Asc')->with('assessment')->get(); 


        $decision_id = $id;

        return view('dashboard.admin.assessment.saw',compact('criterias','employes','criteria_filtered','decision_id'));
    }

    public function result($id)
    {
        $criterias = Criteria::orderBy('criteria_code', 'Asc')
            ->whereHas('assessment', function ($query) use ($id) {
                $query->where('decision_id', $id);
            })
            ->with('sub_criteria')
            ->get();

        $criteria_filtered = Criteria::orderBy('criteria_code', 'Asc')
            ->has('assessment')
            ->with('sub_criteria')
            ->get();

        $employes = Employe::orderBy('id', 'Asc')
            ->whereHas('assessment', function ($query) use ($id) {
                $query->where('decision_id', $id);
            })
            ->with(['assessment' => function ($query) use ($id) {
                $query->where('decision_id', $id);
            }])
            ->get();

        $arr = Assessment::dss_saw($id);

        $decision_id = $id;

        return view('dashboard.admin.assessment.result', compact('criterias', 'employes', 'arr', 'criteria_filtered', 'decision_id'));
    }

    // public function export(){
    //     $criteria_filtered = Criteria::orderBy('criteria_code','Asc')->with('sub_criteria')->get();
    //     $arr = Assessment::dss_saw();
    //     $pdf = PDF::loadview('dashboard.admin.assessment.rank',compact('criteria_filtered','arr'))->setPaper('a4', 'landscape');
    // 	return $pdf->download('Employe Rank');
    // }

    public function export($id){
        $criteria_filtered = Criteria::orderBy('criteria_code', 'Asc')
            ->has('assessment')
            ->with('sub_criteria')
            ->get();
        $arr = Assessment::dss_saw($id);
        $pdf = PDF::loadview('dashboard.admin.assessment.rank',compact('criteria_filtered','arr'))->setPaper('a4', 'landscape');
    	return $pdf->download('Employe Rank');
    }

    public function store(Request $request){
        // return $request->all();
        request()->validate([
            'decision_id'=>['required'],
            'criteria_id'=>['required'],
            'weight'=>['required']
        ]);
            if (count(Criteria::get())!=count($request->weight)) {
                return redirect()->route('assessment')->withErrors('Please Choose All Criteria Weight');
            }
        $arr=[];
        foreach($request['criteria_id'] as $index => $criteria_id){
            $arr[]=[
                'decision_id'=>$request['decision_id'],
                'employe_id'=>$request['employe_id'],
                'criteria_id'=>$criteria_id,
                'weight'=>$request['weight'][$index]
            ];
        }
        // return $arr;
        foreach($arr as $data){
            try {
                Assessment::updateOrCreate([
                'decision_id'=>$request['decision_id'],
                'employe_id'=>$request['employe_id'],
                'criteria_id'=>$data['criteria_id'],
                ],[
                'weight'=>$data['weight']
                ]);
            } catch (\Throwable $th) {
                // return $th;
                return redirect()->route('assessment')->withErrors('Error');
            }
        }
        return back()->withSuccess('Success');
    }

    
}
