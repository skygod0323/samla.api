<?php

namespace App\Http\Controllers\Api;

use App\Entities\Profile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Entities\Image;
use App\Entities\Download;
use App\Entities\Category;
use App\Entities\ModelRelease;

class DashboardController extends Controller {

  public function getDahsobardInfo(Request $request) {

    $imageCount = Image::count();
    $downloadCount = Download::count();
    $categoryCount = Category::count();
    $modelReleaseCount = ModelRelease::count();


    $images = Image::orderBy('downloads', 'desc')->take(3)->get();

    return response()->json([
      'success' => true,
      'data' => [
        'imageCount' => $imageCount,
        'downloadCount' => $downloadCount,
        'categoryCount' => $categoryCount,
        'modelReleaseCount' => $modelReleaseCount,
        'images' => $images
      ]
    ]);
  }
}