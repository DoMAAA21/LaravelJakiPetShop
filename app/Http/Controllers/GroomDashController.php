<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\GroomingChart;
use Carbon;
use DB;
class GroomDashController extends Controller
{
     public function index() {

        $grooming = DB::table('groom_infos')->join('services','service_id','services.id')->groupBy('services.name')
            ->pluck(DB::raw('count(services.name) as total'),'services.name')
            ->toArray();
                //dd($disease);
        $groomingChart = new GroomingChart;

        $dataset = $groomingChart->labels(array_keys($grooming));
        // $dataset = $genreChart->labels(array_keys($albums));
        // $dataset = $genreChart->dataset('Album Genre', 'bar', array_values($albums));
$dataset = $groomingChart->dataset('Number of Pets Groomed', 'bar', array_values($grooming));
        $dataset = $dataset->backgroundColor(collect(['#900020']));
$groomingChart->options([
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

// $diseaseChart = $groomingChart;

    return view('chart.grooming', compact('groomingChart') );

    }





     public function timepick(Request $request) {

          

          // $startDate=   \Carbon\Carbon::parse($request->startdate)->format('d/m/Y');
          //   $endDate = \Carbon\Carbon::parse($request->enddate)->format('d/m/Y') ;


            $startDate = $request->startdate;
              $endDate = $request->enddate;

            //dd($startDate);
        $grooming = DB::table('groom_infos')->join('services','service_id','services.id')->groupBy('services.name')->whereBetween('groom_infos.date', [$startDate, $endDate])
            ->pluck(DB::raw('count(services.name) as total'),'services.name')
            ->toArray();
                //dd($disease);
        $groomingChart = new GroomingChart;

        $dataset = $groomingChart->labels(array_keys($grooming));
        // $dataset = $genreChart->labels(array_keys($albums));
        // $dataset = $genreChart->dataset('Album Genre', 'bar', array_values($albums));
$dataset = $groomingChart->dataset('Number of Pets Groomed', 'bar', array_values($grooming));
        $dataset = $dataset->backgroundColor(collect(['#900020']));
$groomingChart->options([
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

// $diseaseChart = $groomingChart;


     // $grooming = DB::table('groom_infos')->join('services','service_id','services.id')->groupBy('services.name')->whereBetween('groom_infos.date', [$startDate, $endDate])
     //        ->pluck(DB::raw('count(services.name) as total'),'services.name');
            //dd($grooming);
    return view('chart.grooming', compact('groomingChart') );

    }
}
