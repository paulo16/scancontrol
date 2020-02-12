<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\Debugbar\Facade as Debugbar;
use Illuminate\Support\Facades\Storage;

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

        // Handle File Upload
        if($request->hasFile('fichierexcel')) {
            // Get filename with extension            
            $filenameWithExt = $request->file('fichierexcel')->getClientOriginalName();
            // Get just filename
            $filename = "fichierexcel" ;//pathinfo($filenameWithExt, PATHINFO_FILENAME)            
           // Get just ext
            $extension = $request->file('fichierexcel')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'.'.$extension;                       
          // Upload Image
            $path = $request->file('fichierexcel')->storeAs(null,$fileNameToStore);
        } 


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

    	$pdf_champs = array();

    	if($fichier=Storage::disk('local')->path('fichierexcel.xlsx')){
    		$sheet = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    		$sheet = $sheet->load($fichier);

    		$highestRow = $sheet->getActiveSheet()->getHighestRow(); 
    		$highestColumn = $sheet->getActiveSheet()->getHighestColumn();

    		$columnLoopLimiter = $highestColumn;
    		++$columnLoopLimiter;
            // get the column headings as a simple array indexed by column name
    		$headings = $sheet->getActiveSheet()->rangeToArray('A1:' . $highestColumn . 1, NULL, TRUE, FALSE, TRUE)[1];
    		$col_chemin =array_search('chemin', $headings);
    		$lettre_chemin_pdf = $col_chemin;
    		$rowdebut= 2;

    		$rowData = $sheet->getActiveSheet()->rangeToArray($lettre_chemin_pdf. $rowdebut . ':' . $lettre_chemin_pdf. $highestRow , NULL, TRUE, FALSE, TRUE);

    		$rowAllData = $sheet->getActiveSheet()->rangeToArray("A". $rowdebut . ':' . $lettre_chemin_pdf. $highestRow , NULL, TRUE, FALSE, TRUE);
            Debugbar::info($rowData);
            //  Loop through each data row of the worksheet in turn
    		for ($row = 2; $row <= $highestRow; $row++)
    		{ 
    			if (!empty($rowData[$row][$lettre_chemin_pdf]) && (strtolower($request->get('pdf_nomsimple')) == strtolower(

    				$rowData[$row][$lettre_chemin_pdf]))) {

                    $values = $rowAllData[$row]; 
                    $new = array_combine(preg_replace(array_map(function($s){return "/^$s$/";}, 
                                                 array_keys($headings)),$headings, array_keys($values)), $values);
                    Debugbar::info($new);
    				$pdf_champs = $new;
    				break;
    			}
    		}

    	}else{

    	}
 
        return response()->json(['pdf_url'=>$url, "pdf_champs"=>$pdf_champs]);

	}

	public function saveenetetesinfile(Request $request){

		if($request->get('entetes')){

			Storage::disk('local')->put('entetes.txt', $request->get('entetes'));

			return response()->json(["msg"=>"save ok"]);

		}

		return  response()->json(["msg"=>"not save"]);

	}

	public function savelesremarques(Request $request){

		$namefile='remarques_'.date('d-m-Y').'.csv';
		$storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

		if($request->get('remarques') && $request->get('pdf_ref') ){

            if (!Storage::disk('local')->exists($namefile)) {
            	
            	$entetes= '"Nom de Pdf ", "Les Remarques"';
            	if(Storage::disk('local')->put($namefile, null)){
                   
				    $content = '"'.$request->get('pdf_ref').'"'.','.'"'.$request->get('remarques').'"';

				    file_put_contents($storagePath.'/'.$namefile,iconv('UTF-8', 'ASCII//TRANSLIT', $entetes ). "\n", FILE_APPEND);
				    file_put_contents($storagePath.'/'.$namefile,iconv('UTF-8', 'ASCII//TRANSLIT', $content) . "\n", FILE_APPEND);

            	}

            }else{
            	//$f = fopen($storagePath.'/'.$namefile , "w");
				//fputcsv($f, [$request->get('pdf_ref'),$request->get('remarques'),"\r\n"]);
				$content = '"'.$request->get('pdf_ref').'"'.','.'"'.$request->get('remarques').'"';

				file_put_contents($storagePath.'/'.$namefile,iconv('UTF-8', 'ASCII//TRANSLIT', $content) . "\n", FILE_APPEND);
            }
			return response()->json(["remarques"=>"save ok"]);

		}

		return  response()->json(["remarques"=>"not save"]);
	}

	public function exportremarques(Request $request){

		$namefile='remarques_'.date('d-m-Y').'.csv';
		return Storage::disk('local')->download($namefile);
	}

}
