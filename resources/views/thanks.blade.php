@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="header">
        <div class="header-body">
            <div class="row align-items-center">
                <div class="col">
                    <h1 class="header-title">
                         Спасибо за фотку!
                    </h1>
                </div>
            </div>

        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane fade active show" id="tabPaneOne" role="tabpanel">
            <div class="row listAlias">
              <!-- Card -->
                 <div class="card" style="margin: 10% 30%">
                     <img src="{{$image->path}}" alt="{{$image->name}}" class="card-img-top" height="400">
                     <div class="card-body">
                         <div class="row align-items-center">
                             <div class="col">

                                 <!-- Name -->
                                 <h4 class="card-title mb-2 name">
                                     {{$image->name}}
                                 </h4>

                                 <!-- Location -->
                                 <p class="card-text small text-muted">
                                     @foreach($locations as $location)
                                       @if($location->id == $image->location_id)
                                         {{$location->name}}
                                       @endif
                                     @endforeach
                                 </p>

                                 <!-- Date -->
                                 <p class="card-text small text-muted">
                                     {{$image->date}}
                                 </p>

                                 <!-- Description -->
                                 <p class="card-text mb-2">
                                     {{$image->description}}
                                 </p>



                                     <a href="/" class="btn btn-primary">На главную</a>



                             </div>
                         </div> <!-- / .row -->

                     </div> <!-- / .card-body -->
                 </div>
            </div>
        </div>
    </div>
</div>

@endsection
