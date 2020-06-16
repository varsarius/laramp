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
      if (Auth::check() && Auth::user()->name == 'Admin'){
        return view('admin', [
          //'years => Уникальные года Всё->Года->Уникальные года
            'images' => Image::all()->sortBy('is_verified'),
            'locations' => Location::all()
        ]);
      } else {
      		return view('main', [
       		'images' => Image::all()->where('is_verified', 1),
        	'locations' => Location::all()
      	]);
      }
  }

  public function create(ImageRequest $request)
  {

      // $data = $this->validate($request, [
      //     'name' => 'required|string',
      //     'description' => 'nullable|string',
      //     'location_id' => 'nullable|numeric', // Переделать string на numeric \done
      //     'date' => 'nullable|date', //Дата - я не понимать \done
      //     'file' => 'required|image', // как-то надо сделать чтобы было только hpg, jpeg, img и др.image|mimes:jpeg,bmp,png|size:2000 \done
      // ]);

      $image = new Image;

      $image->name = request('name');

      if (isset($data['description']))
          $image->description = request('description');
      if (isset($data['location_id']))
          $image->location_id = request('location_id');
      if (isset($data['date']))
          $image->date = request('date');

      $fileName =  $request->file('file')->getClientOriginalName();
      $fileExt = explode('.', $fileName);
      $fileActualExt = strtolower(end($fileExt));
      $image->path = 'img/'.uniqid('', true).'.'.$fileActualExt;
      move_uploaded_file($request->file('file')->getPathName(), $image->path);

      $image->save(); // не работает не пойми почему \теперь работает

      return redirect('/');
  }

  public function filter(Request $request)
  {
      $data = $this->validate($request, [
          'location_id' => 'nullable|numeric', // Переделать string на numeric \done
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
      return redirect('/');
    }
}
