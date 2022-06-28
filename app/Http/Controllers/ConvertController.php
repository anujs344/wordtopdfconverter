<?php

namespace App\Http\Controllers;
use Spatie\PdfToText\Pdf;
use Illuminate\Http\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use \ConvertApi\ConvertApi;

/**
 * Import the PDF Parser class
 */
use Smalot\PdfParser\Parser;
class ConvertController extends Controller
{
    public function topdf(Request $request)
    {
        //Saving PDF File
        $fileName = time().'.'.$request->file('pdf')->extension();  
        $request->file('pdf')->move(public_path('storage/ebutifier/pdf'), $fileName);



        //------------------Converting to Word------------------------------
        ConvertApi::setApiSecret('dIP63zKWqJAPrtq8');

        $result = ConvertApi::convert('doc', ['File' => public_path('storage/ebutifier/pdf/'.$fileName)]);

        # save to file
        $timezone = time();
        $result->getFile()->save('storage/'.$timezone.'.doc');

        # get file contents (without saving the file locally)
        // $contents = $result->getFile()->getContents();

        //---------------------End of Converting to Word---------------------

        //Deleting Pdf File
        // unlink(public_path('storage/ebutifier/pdf/'.$fileName));
        
        //Downloading Doc File
        return response()->download(public_path('storage/'.$timezone.'.doc'));

        //Deleting Doc File
        // unlink(public_path('storage/'.$timezone.'.doc'));

    }
}
