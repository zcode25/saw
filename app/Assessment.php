<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    //
    protected $guarded = [];
    
    public static function getMaxMin($criterias){
        $arr=[];
        foreach ($criterias as $key => $criteria) {
        $decoded = json_decode($criteria->assessment,true);
        $arr[$criteria['criteria_code']]=[
        'name'=>$criteria['name'],
        'type'=>$criteria['type'],'max_weight'=>max(array_column($decoded, 'weight')),
        'min_weight'=>min(array_column($decoded, 'weight'))] ;
        }
        return $arr;
    }
    // public static function dss_saw(){
    //     $criterias = Criteria::orderBy('criteria_code','Asc')->has('assessment')->with('sub_criteria')->get();
    //     $employes = Employe::orderBy('id','Asc')->has('assessment')->with('assessment')->get(); 
    //     $arr = [];
    //     $score=[];
    //     $minmax =  self::getMaxMin($criterias);
    //     foreach($employes as $index => $employe){
    //         $arr[$index] =[
    //             'full_name'=>$employe->full_name
    //         ];
    //          foreach($criterias as $key => $criteria){
    //              foreach($employe->assessment as $assessment){
    //                 if($assessment->criteria_id==$criteria->id){
    //                     $arr[$index]['criteria'][$criteria->criteria_code]=[
    //                         'name'=>$criteria->name,
    //                         'type'=>$criteria->type,
    //                         'weight'=>$assessment->weight,
    //                     ];
    //                     if ($criteria->type=='benefit') {
    //                         $result=$assessment->weight/$minmax[$criteria->criteria_code]['max_weight'];
    //                     }else{
    //                         $result=$minmax[$criteria->criteria_code]['min_weight']/$assessment->weight;
    //                     }
    //                     $arr[$index]['criteria'][$criteria->criteria_code]['result'] = $result;
    //                     $score[$index][]=$result*$criteria->weight;
    //                 }
    //             }
    //         }
    //         // dd($score);
    //         $arr[$index]['score']=array_sum($score[$index]);
    //     }
    //     foreach ($arr as $key => $row)
    //         {
    //             $score[$key] = $row['score'];
    //         }
    //     array_multisort($score, SORT_DESC, $arr);
    //     return $arr;
    // }

    public static function dss_saw($decision_id)
    {
        // Filter kriteria berdasarkan decision_id
        $criterias = Criteria::orderBy('criteria_code', 'Asc')
            ->whereHas('assessment', function ($query) use ($decision_id) {
                $query->where('decision_id', $decision_id);
            })
            ->with(['sub_criteria'])
            ->get();

        // Filter employe berdasarkan decision_id
        $employes = Employe::orderBy('id', 'Asc')
            ->whereHas('assessment', function ($query) use ($decision_id) {
                $query->where('decision_id', $decision_id);
            })
            ->with(['assessment' => function ($query) use ($decision_id) {
                $query->where('decision_id', $decision_id);
            }])
            ->get();

        $arr = [];
        $score = [];
        $minmax = self::getMaxMin($criterias);

        foreach ($employes as $index => $employe) {
            $arr[$index] = [
                'full_name' => $employe->full_name
            ];
            foreach ($criterias as $key => $criteria) {
                foreach ($employe->assessment as $assessment) {
                    if ($assessment->criteria_id == $criteria->id) {
                        $arr[$index]['criteria'][$criteria->criteria_code] = [
                            'name' => $criteria->name,
                            'type' => $criteria->type,
                            'weight' => $assessment->weight,
                        ];
                        if ($criteria->type == 'benefit') {
                            $result = $assessment->weight / $minmax[$criteria->criteria_code]['max_weight'];
                        } else {
                            $result = $minmax[$criteria->criteria_code]['min_weight'] / $assessment->weight;
                        }
                        $arr[$index]['criteria'][$criteria->criteria_code]['result'] = $result;
                        $score[$index][] = $result * $criteria->weight;
                    }
                }
            }
            $arr[$index]['score'] = array_sum($score[$index]);
        }

        foreach ($arr as $key => $row) {
            $score[$key] = $row['score'];
        }
        array_multisort($score, SORT_DESC, $arr);

        return $arr;
    }

    public static function graphic_saw($decision_id)
    {
        // Filter kriteria berdasarkan decision_id
        $criterias = Criteria::orderBy('criteria_code', 'Asc')
            ->whereHas('assessment', function ($query) use ($decision_id) {
                $query->where('decision_id', $decision_id);
            })
            ->with(['sub_criteria'])
            ->get();

        // Filter employe berdasarkan decision_id
        $employes = Employe::orderBy('id', 'Asc')
            ->whereHas('assessment', function ($query) use ($decision_id) {
                $query->where('decision_id', $decision_id);
            })
            ->with(['assessment' => function ($query) use ($decision_id) {
                $query->where('decision_id', $decision_id);
            }])
            ->get();

        $arr = [];
        $score = [];
        $minmax = self::getMaxMin($criterias);

        foreach ($employes as $index => $employe) {
            $total_score = 0;
            foreach ($criterias as $criteria) {
                foreach ($employe->assessment as $assessment) {
                    if ($assessment->criteria_id == $criteria->id) {
                        if ($criteria->type == 'benefit') {
                            $result = $assessment->weight / $minmax[$criteria->criteria_code]['max_weight'];
                        } else {
                            $result = $minmax[$criteria->criteria_code]['min_weight'] / $assessment->weight;
                        }
                        $total_score += $result * $criteria->weight;
                    }
                }
            }
            $arr[] = [
                'full_name' => $employe->full_name,
                'score' => $total_score,
            ];
        }

        usort($arr, fn($a, $b) => $b['score'] <=> $a['score']); // Sort descending by score

        return $arr;
    }


}
