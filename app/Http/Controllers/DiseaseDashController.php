<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Charts\DiseaseChart;

use DB;
// use App\Models\Customer; 
class DiseaseDashController extends Controller
{
     public function index() {

        $disease = DB::table('checkup_infos')->join('diseases','disease_id','diseases.id')->groupBy('name')
            ->pluck(DB::raw('count(name) as total'),'name')
            ->toArray();
                //dd($disease);
        $diseaseChart = new DiseaseChart;

        $dataset = $diseaseChart->labels(array_keys($disease));
        // $dataset = $genreChart->labels(array_keys($albums));
        // $dataset = $genreChart->dataset('Album Genre', 'bar', array_values($albums));
$dataset = $diseaseChart->dataset('Number of Pets have this disease', 'line', array_values($disease));
        $dataset = $dataset->backgroundColor(collect(['#900020']));
$diseaseChart->options([
            'responsive' => true,
            // 'legend' => ['display' => true],
            'tooltips' => ['enabled'=> true],
            // 'maintainAspectRatio' =>true,
            'title' => [
                'display'=> true,
                'text' => ''
              ],
              // 'title' => 'genre',
            'aspectRatio' => 1,
            'scales' => [
                'yAxes'=> [[
                            'display'=>true,
                            'ticks'=> ['beginAtZero'=> true],
                            'gridLines'=> ['display'=> true],
                          ]],
 'xAxes'=> [[
                            'categoryPercentage'=> 0.8,
                            //'barThickness' => 100,
                            'barPercentage' => 1,
                            'ticks' => ['beginAtZero' => false],
                            'gridLines' => ['display' => true],
                            'display' => true

                          ]],
            ],
     // 'plugins' => '{datalabels: { font: { weight: \'bold\',
                //                          size: 36 },
                //                          color: \'white\',
                //                 }}',
                //                 '{outlabels: {display: true}}',
        ]);

    return view('chart.disease', compact('diseaseChart') );

    }
}
