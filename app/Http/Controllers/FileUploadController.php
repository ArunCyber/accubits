<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
	public function index() {
		return view('welcome');
	}

	public function fileUpload(Request $request) {
		$filename = $request->file("filename");
		$err = array();

		if($filename->getClientOriginalExtension() == "csv") {
			if (($handle = fopen($filename, "r")) !== FALSE) {
				$i=0;
			    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			        $num = count($data);

			        if ($i != 0) {
			        	if(preg_match('/[0-9]/', $data[0])) {
			        		$err[] = "Module Code contains symbols or charchters at row " . $i;
			        	}

			        	if($data[1] == "") {
			        		$err[] = "Module Name is missing at row " . $i;
			        	}

			        	if($data[2] == "") {
			        		$err[] = "Term Name is missing at row " . $i;
			        	}

			        	if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $data[2])) {
			        		$err[] = "Term Name contains symbols at row " . $i;
			        	}

			        	DB::table('details')->insert(
					     	array(
					        	'module_code'     =>   $data[0], 
					            'module_name'   =>   $data[1],
					            'module_term'   =>   $data[2]
					     	)
						);
			        		
					} else {
						if($data[0] != "Module_code" || $data[1] != "Module_name" ||$data[2] != "Module_term") {
							$err[] = "Header Column is incorrect in CSV file";
						}
					}

					$i++;
			    }

			    fclose($handle);
			}
			echo "Data uploaded.";
			$error_details = implode(', ', $err);

			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			if(mail("charush@accubits.com", "Data uploading Error", $error_details, $headers)) {
				echo "Mail send with details of errors in the file.";
			}
		} else {
			echo "Extension not supported!";
		}
        
	}
}
