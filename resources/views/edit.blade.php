@extends('layouts.app')

@section('content')
    <div style="width: 100%; height: 100%" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="photo_modal">Редактирование фотографии</h5>
            </div>
            <div class="modal-body">
                <form action="/editsave/{{$image->id}}" method="post" enctype="multipart/form-data" class="mb-4" data-select2-id="4">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="mb-4">
                            Название фотографии
                        </label>
                        <input name="name" value="{{$image->name}}" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="mb-4">
                            Описание
                        </label>
                        <textarea name="description" cols="30" rows="10" class="form-control">{{$image->description}}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="mb-4">
                            Город
                        </label>
                    <select name="location_id" class="browser-default custom-select custom-select-lg mb-3">
                        <option value="0">Выберите город</option>
                        @foreach($locations as $location)
                              @if($location->id == $image->location_id)
                                <option value="{{$location->id}}" selected="selected">{{$location->name}}</option>
                              @else
                                <option value="{{$location->id}}">{{$location->name}}</option>
                              @endif
                        @endforeach
                    </select>
                    </div>


                    <div class="row">
                        <div class="col-12 col-md-12">

                            <!-- Start date -->
                            <div class="form-group">
                                <label>
                                    Дата
                                </label>
                                <input value="{{$image->date}}" name="date" type="date" class="form-control flatpickr-input" data-toggle="flatpickr">
                            </div>

                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col"></div>
                        <div class="col-auto">
                            <a href="/" type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</a>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <img src="{{asset($image->path)}}" alt="{{$image->name}}" class="card-img-top" height="400" style="
      z-index: -1;
      width: 100%;
      height: 100%;
    ">
@endsection
