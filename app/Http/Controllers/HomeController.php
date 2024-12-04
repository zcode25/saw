<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Employe;
use App\Criteria;
use App\SubCriteria;
use App\Assessment;
use App\Decision;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function index(Request $request)
     {
         $decisions = Decision::orderBy('decision_date', 'desc')->get();
         
         // Periksa apakah ada data di $decisions
         if ($decisions->isEmpty()) {
             $decision_id = null; // Atur default null jika tidak ada data
         } else {
             $first = $decisions->first();
             $decision_id = $request->get('decision_id', $first->id);
         }
     
         $employe = Employe::count();
         $assessment_success = Decision::count();
         $criteria = Criteria::count();
         $sub_criteria = SubCriteria::count();
     
         // Jika decision_id null, kosongkan $rankings
         $rankings = $decision_id ? Assessment::graphic_saw($decision_id) : [];
     
         return view('dashboard.admin.home', compact(
             'criteria',
             'sub_criteria',
             'employe',
             'assessment_success',
             'rankings',
             'decisions',
             'decision_id'
         ));
     }
}
