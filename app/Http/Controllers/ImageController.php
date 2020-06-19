<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use http\QueryString;
use Illuminate\Http\Request;

use File;
use Auth;
use App\Image;
use App\Location;
use App\Http\Requests\ImageRequest;
class ImageController extends Controller
{
  public function show()
  {
      $years = array();
      if (Auth::check() && Auth::user()->name == 'Admin')
        $imDates = Image::get(['date']);
      else
        $imDates = Image::where('is_verified', 1)->get(['date']);

      foreach ($imDates as $imDate) {
        if (isset($imDate->date))
          array_push($years, substr($imDate->date,0,4));
      }
      $years = array_unique($years);

      if (Auth::check() && Auth::user()->name == 'Admin'){
        return view('admin', [
          //'years => Уникальные года Всё->Года->Уникальные года
            'images' => Image::orderBy('is_verified')->paginate(50),
            'locations' => Location::all(),
            'years' => $years
        ]);
      } else {
      		return view('main', [
       		'images' => Image::where('is_verified', 1)->paginate(3),
        	'locations' => Location::all(),
          'years' => $years
      	]);
      }
  }

  public function create(ImageRequest $request)
  {

      $image = new Image;

      $image->name = request('name');

      if (isset($request['description']))
          $image->description = request('description');
      if (isset($request['location_id']))
          $image->location_id = request('location_id');
      if (isset($request['date']))
          $image->date = request('date');

      $fileName =  $request->file('file')->getClientOriginalName();
      $fileExt = explode('.', $fileName);
      $fileActualExt = strtolower(end($fileExt));
      $image->path = 'img/'.uniqid('', true).'.'.$fileActualExt;
      move_uploaded_file($request->file('file')->getPathName(), $image->path);

      $image->save();



      return view('thanks', [
        'image' => $image,
        'locations' => Location::all()
      ]);
  }

  public function filter(Request $request)
  {
      $data = $this->validate($request, [
          'location_id' => 'nullable|numeric',
          'year' => 'nullable|numeric'
      ]);

      $query = Image::where('is_verified', 1);

      if (isset($data['location_id'])) {
          $query->where('location_id', request('location_id'));
      }

      if(isset($data['year'])) {
         $from = Carbon::create($data['year'], 1, 1);
         $to = Carbon::create($data['year'], 12, 31);
         $query->whereBetween('date', [$from, $to])->get();
      }

      $images = $query->get();

      return view('main', [
          'images' => $images,
          'locations' => Location::all()
      ]);
    }

    public function delete(Request $request)
    {
      $data = $this->validate($request, [
          'id' => 'required|numeric',
      ]);
      if (isset($data['id'])) {
        $image = Image::findOrFail($data['id']);
        File::delete($image->path);
        $image->delete();
      }
      return redirect()->back();
    }

    public function permit(Request $request)
    {
      $data = $this->validate($request, [
          'id' => 'required|numeric',
      ]);

      if (isset($data['id'])) {
        $image = Image::findOrFail($data['id']);

        if($image->is_verified == 1){
          $image->is_verified = 0;
        } elseif($image->is_verified == 0){
          $image->is_verified = 1;
        }

        $image->save();
      }
      return redirect()->back();
    }

    public function edit($id)
    {
      //dd($id);
      return view('edit', [
          'image' => Image::findOrFail($id),
          'locations' => Location::all()
      ]);
    }

    public function editsave($id, Request $request)
    {
      $data = $this->validate($request, [
         'name' => 'required|string',
         'description' => 'nullable|string',
         'location_id' => 'nullable|numeric',
         'date' => 'nullable|date',
      ]);
      $image = Image::findOrFail($id);


      $image->name = request('name');
      $image->description = request('description');
      $image->location_id = request('location_id');
      $image->date = request('date');

      $image->save();
      return redirect('/')->withInputs();
    }
}
