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


	public function getlespdfs(Request $request){
		$les_pdfs= array();

		if($request->get('dossier_cible')){
           		$path_to_directory = $request->get('dossier_cible');

		$files = glob($path_to_directory. '\*.{pdf,PDF}', GLOB_BRACE);
		

		foreach($files as $file1) {
             $info1 = pathinfo($file1);
             $name = $info1['basename']; 
             $les_pdfs[] = ["chemin" =>$file1 ,"nom_pdf"=>$name] ;

        }
		}

        return response()->json(['les_pdfs'=>$les_pdfs]);


    }

    public function getPdfbyName(Request $request){

    	$url ='';

    	if($request->get('pdf_chemincomplet')){

            $nomdossier= "1-Les_scans";
    		$destination = public_path().'\\'.$nomdossier;

    		if(copy($request->get('pdf_chemincomplet'), $destination.'\\'.$request->get('pdf_nomsimple'))){

    			$url = \URL::asset($nomdossier.'/'.$request->get('pdf_nomsimple'));

    		}
    	}
 
        return response()->json($url);

	}

}
