<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facade as Debugbar;

class ScanController extends Controller
{
	public function getentetes(Request $request){
		$noms_fichiers=array();
		$headings =array();

		if($request->has('fichierexcel')){
			$sheet = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
			$sheet = $sheet->load($request->fichierexcel);

			$highestRow = $sheet->getActiveSheet()->getHighestRow(); 
			$highestColumn = $sheet->getActiveSheet()->getHighestColumn();

			$columnLoopLimiter = $highestColumn;
			++$columnLoopLimiter;
        // get the column headings as a simple array indexed by column name
			$headings = $sheet->getActiveSheet()->rangeToArray('A1:' . $highestColumn . 1, NULL, TRUE, FALSE, TRUE)[1];

		}
        Debugbar::info($headings);
		return  response()->json(['lesentetes'=> $headings]);

	}
}
