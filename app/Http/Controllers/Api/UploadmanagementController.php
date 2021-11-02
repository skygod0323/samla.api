<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Entities\Category;
use App\Entities\Image;
use App\Entities\ModelRelease;

class UploadmanagementController extends Controller {

  public function getCategoryList(Request $request) {
    
    $query = "SELECT categories.*, COUNT(images.id) imagecount FROM categories LEFT JOIN images ON CONCAT(',', images.categories,',') LIKE CONCAT('%,', categories.id, ',%') GROUP BY categories.id";

    $categories = \DB::select($query);

    return response()->json([
      'success' => true,
      'data' => $categories
    ]);

  }

  public function createCategory(Request $request) {
    $input = $request->input();

    if (Category::where('name', $input['name'])->count() > 0) {
        return response()->json(['success' => false, 'error' => 'Name already exist']);
    }

    $category = new Category;

    $category->name = $input['name'];

    $category->save();

    return response()->json(['success' => true]);
  }

  public function updateCategory(Request $request) {
    $input = $request->input();

    $category = Category::where('id', $input['id'])->first();

    $category->name = $input['name'];

    $category->save();

    return response()->json(['success' => true]);
  }

  public function createImage(Request $request) {
    $input = $request->input();
    $images = $input['images'];

    foreach($images as $imageData) {
      $image = new Image();

      $image->name = $imageData['name'];
      $image->imageurl = $imageData['imageurl'];
      $image->lowimageurl = $imageData['lowimageurl'];
      $image->title = $imageData['title'];
      $image->description = $imageData['description'];
      
      $image->photographer = $imageData['photographer'];
      $image->phone = $imageData['phone'];
      $image->email = $imageData['email'];
      $image->sublocation = $imageData['sublocation'];
      $image->city = $imageData['city'];
      $image->country = $imageData['country'];
      $image->lat = $imageData['lat'];
      $image->long = $imageData['long'];

      $image->categories = implode(",", $imageData['categories']);
      
      if (isset($imageData['modelReleases'])) {
        $image->modelreleases = implode(",", $imageData['modelReleases']);
      }

      if (isset($imageData['tags'])) {
        $image->tags = implode(",", $imageData['tags']);
      }
      $image->save();
    }

    return response()->json(['success' => true]);
  }

  public function updateImage(Request $request) {
    $input = $request->input();
    
    $image = Image::where('id', $input['id'])->first();

    $image->name = $input['name'];
    $image->imageurl = $input['imageurl'];
    $image->lowimageurl = $input['lowimageurl'];
    $image->title = $input['title'];
    $image->description = $input['description'];
    
    $image->photographer = $input['photographer'];
    $image->phone = $input['phone'];
    $image->email = $input['email'];
    $image->sublocation = $input['sublocation'];
    $image->city = $input['city'];
    $image->country = $input['country'];
    $image->lat = $input['lat'];
    $image->long = $input['long'];

    $image->categories = implode(",", $input['categories']);

    if (isset($input['modelReleases'])) {
      $image->modelreleases = implode(",", $input['modelReleases']);
    }

    if (isset($input['tags'])) {
      $image->tags = implode(",", $input['tags']);
    }
    

    $image->save();

    return response()->json(['success' => true]);
  }

  public function getImageList(Request $request) {
    $images = Image::orderBy('created_at', 'DESC')->get();
    $categories = Category::all();
    $modelReleases = ModelRelease::all();

    $catlist = array();
    $modelList = array();

    foreach ($categories as $cat) {
      $catlist[$cat->id] = $cat;
    }

    foreach ($modelReleases as $mol) {
      $modelList[$mol->id] = $mol;
    }


    foreach($images as $image) {
      if (!empty($image['categories'])) {
                
        $categoryids = explode(",", $image['categories']);

        $imageCatList = [];
        foreach ($categoryids as $id) {
          if (isset($catlist[$id])) {
            array_push($imageCatList, $catlist[$id]);
          }
        }
        $image['categories'] = $imageCatList;
      } else {
        $image['categories'] = [];
      }

      if (!empty($image['modelreleases'])) {
                
        $modelreleaseids = explode(",", $image['modelreleases']);

        $imageModelReleaseList = [];
        foreach ($modelreleaseids as $id) {
          if (isset($modelList[$id])) {
            array_push($imageModelReleaseList, $modelList[$id]);
          }
        }
        $image['modelreleases'] = $imageModelReleaseList;
      } else {
        $image['modelreleases'] = [];
      }

      if (!empty($image['tags'])) {
        $image['tags'] = explode(',', $image['tags']);
      } else {
        $image['tags'] = [];
      }
    }

    return response()->json([
      'success' => true,
      'data' => $images
    ]);
  }

  public function getImage(Request $request) {
    $input = $request->input();
    
    $image = Image::where('id', $input['id'])->first();
    $categories = Category::all();
    $modelReleases = ModelRelease::all();

    $catlist = array();
    $modelList = array();

    foreach ($categories as $cat) {
      $catlist[$cat->id] = $cat;
    }

    foreach ($modelReleases as $mol) {
      $modelList[$mol->id] = $mol;
    }


    if (!empty($image['categories'])) {
                
      $categoryids = explode(",", $image['categories']);

      $imageCatList = [];
      foreach ($categoryids as $id) {
        if (isset($catlist[$id])) {
          array_push($imageCatList, $catlist[$id]);
        }
      }
      $image['categories'] = $imageCatList;
    } else {
      $image['categories'] = [];
    }

    if (!empty($image['modelreleases'])) {
              
      $modelreleaseids = explode(",", $image['modelreleases']);

      $imageModelReleaseList = [];
      foreach ($modelreleaseids as $id) {
        if (isset($modelList[$id])) {
          array_push($imageModelReleaseList, $modelList[$id]);
        }
      }
      $image['modelreleases'] = $imageModelReleaseList;
    } else {
      $image['modelreleases'] = [];
    }

    if (!empty($image['tags'])) {
      $image['tags'] = explode(',', $image['tags']);
    } else {
      $image['tags'] = [];
    }

    

    return response()->json([
      'success' => true,
      'data' => $image
    ]);
  }

  public function getModelReleaseList(Request $request) {
    $query = "SELECT modelreleases.*, COUNT(images.id) imagecount FROM modelreleases LEFT JOIN images ON CONCAT(',', images.modelreleases,',') LIKE CONCAT('%,', modelreleases.id, ',%') GROUP BY modelreleases.id";

    $modelReleases = \DB::select($query);

    return response()->json([
      'success' => true,
      'data' => $modelReleases
    ]);
  }

  public function createModelRelease(Request $request) {

    $input = $request->input();

    $modelRelease = new ModelRelease;

    $modelRelease->name = $input['name'];
    $modelRelease->url = $input['url'];

    $modelRelease->save();

    return response()->json(['success' => true]);
  }

  public function deleteImage(Request $request) {
    $input = $request->input();
    $id = $input['id'];

    Image::where('id', $id)->delete();

    return response()->json([
      'success' => true
    ]);
  }
  
}