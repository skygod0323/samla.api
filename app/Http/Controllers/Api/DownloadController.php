<?php

namespace App\Http\Controllers\Api;

use App\Entities\Profile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Entities\Image;
use App\Entities\Download;
use App\Mail\DownloadMail;
use Illuminate\Support\Facades\Mail;

class DownloadController extends Controller
{
  public function checkout(Request $request) {

    $input = $request->input();

    $info = $request['info'];
    $imageIds = $input['images']; 

    
    ///////// image downlad from S3 and zip files
    $images = Image::whereIn('id', $imageIds)->get();

    $date = date('Y-m-d');
    $dir = str_random(20);

    $downloadPath = '/downloads/'.$date.'/'.$dir;

    foreach($images as $image) {
      if ($info['resolution'] == 'high') {
        $url = $image['imageurl'];
      } else {
        $url = $image['lowimageurl'];
      }
      
      $name = str_random(10).'-'.$image['name'];

      $contents = file_get_contents($url);
      \Storage::disk('public')->put($downloadPath.'/'.$name, $contents);
    }

    $zipper = new \Chumper\Zipper\Zipper;
    $files = glob(public_path().'/storage'.$downloadPath.'/*');
    $zipper->make(public_path().'/storage'.'/zipper/'.$dir.'.zip')->add($files);
    $zipper->close();
    //// end zip


    $download_code = str_random(30);
    Mail::to($info['email'])->send(new DownloadMail($download_code));   /// send email
    
    $zipUrl = env('SERVER_URL').'/storage/zipper/'.$dir.'.zip';

    $download = new Download;
    $download->firstname = $info['firstname'];
    $download->lastname = $info['lastname'];
    $download->email = $info['email'];
    $download->resolution = $info['resolution'];
    $download->images = implode(',', $imageIds);
    $download->downloadlink = $zipUrl;
    $download->downloadcount = 0;
    $download->downloadcode = $download_code;

    $download->save();


    foreach($images as $image) {
      $image->downloads = $image->downloads + 1;
      $image->save();
    }

    return response()->json([
      'success' => true,
    ]);
  }

  public function checkDownload($download_code, Request $request) {
    $download = Download::where('downloadcode', $download_code)->first();
    if (isset($download)) {
      if ($download->downloadcount < 2) {
        return ("<script>location.href = '".env('FRONT_URL')."/download/".$download_code."'</script>");
      } else {
        return ("<script>location.href = '".env('FRONT_URL')."/download/error'</script>");
      }
    } else {
      return ("<script>location.href = '".env('FRONT_URL')."/download/error'</script>");
    }
  }

  public function download($download_code, Request $request) {
    $download = Download::where('downloadcode', $download_code)->first();
    if (isset($download)) {
      $download->downloadcount++;
      $download->save();

      return response()->json([
        'success' => true,
        'url' => $download->downloadlink
      ]);
    } else {
      return response()->json([
        'success' => false,
      ]);
    }
  }
}