@extends(backpack_view('layouts.' . (backpack_theme_config('layout') ?? 'vertical')))

@php
  $breadcrumbs = [
      'Admin' => backpack_url('dashboard'),
      'Dzieci' => backpack_url('child'),
       $entry->first_name.' '.$entry->last_name => false,
  ];
@endphp




@section('content')

<section class="p-4">
    <section class="w-100 p-4 color-primary" style="border-radius: .5rem .5rem 0 0;">
      <div class="row">
        <div class="col-lg-4">
          <div class="card mb-4">
            <div class="card-body text-center">
              <p class="mb-2 mt-0"><span class="text-primary d-flex justify-content-center">Zdjęcie</span></p>
               @if($entry->image_url)
              <img src="{{ asset('storage/'.$entry->image_url) }}" alt="avatar" class="rounded" style="max-height: 200px; height: 60%; width: auto">
            @else
              <img src="{{ asset('storage/Blank-profile.png') }}" alt="no_avatar" class="rounded" style="max-height: 200px; height: 60%; width: auto">
            @endif
            </div>
          </div>
          <div class="card mb-4 mb-lg-0">
            <div class="card-body p-0">
              <p class="mb-2 mt-3"><span class="text-primary d-flex justify-content-center">Szczegóły adopcji</span></p>
              <ul class="list-group list-group-flush rounded-3">
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <p class="mb-0">Data rozpoczęcia:</p>
                  <p class="mb-0">{{$entry->adoption_start_date}}</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <p class="mb-0">Data zakończenia:</p>
                  <p class="mb-0"> /w budowie\</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <p class="mb-0">Czas trwania:</p>
                  <p class="mb-0">{{intval($entry->length_of_adoption/365)}} lat</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <p class="mb-0">Pozostało:</p>
                  <p class="mb-0">
                    @if($entry->getRemainingTime()<1)
                      <span class="badge bg-red text-red-fg">Wygasło</span>
                    @elseif ($entry->getRemainingTime()>= 1 && $entry->getRemainingTime() < 30)
                      <span class="badge bg-orange text-orange-fg"> {{$entry->getRemainingTime()}} dni</span>
                    @elseif ($entry->getRemainingTime()>= 30 && $entry->getRemainingTime() <= 90)
                      <span class="badge bg-yellow text-yellow-fg"> {{$entry->getRemainingTime()}} dni</span>
                    @else <span class="badge bg-green text-green-fg ">{{$entry->getRemainingTime()}} dni</span>
                    @endif
                   
                  </p>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body">
              <p class="mb-3"><span class="text-primary d-flex justify-content-center">Dane dziecka</span></p>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Imię:</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ $entry->first_name }}</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Nazwisko:</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0"> {{ $entry->last_name }}</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Wiek:</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ $entry->age}} lat</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Miejscowość pochodzenia:</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ $entry->birth_place}}</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Kraj pochodzenia:</p>
                </div>
                <div class="col-sm-9">
                  <p class="text-muted mb-0">{{ $entry->country}}</p>
                </div>
              </div>           
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card mb-4 mb-md-0">
                <div class="card-body p-0">
                  <p class="mb-2 mt-3"><span class="text-primary d-flex justify-content-center">Dane opiekuna</span></p>
                  <ul class="list-group list-group-flush rounded-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0">Imię:</p>
                      <p class="mb-0">{{$entry->adopter_first_name}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0">Nazwisko:</p>
                      <p class="mb-0"> {{$entry->adopter_last_name}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0">Chorągiew koordynująca:</p>
                      <p class="mb-0">{{$entry->flag}}</p>
                    </li>   
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0">Komandoria:</p>
                      <p class="mb-0">{{$entry->flag_comandory}}</p>
                    </li>               
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card mb-4 mb-md-0">
                <div class="card-body p-0">
                  <p class="mb-2 mt-3"><span class="text-primary d-flex justify-content-center">Wpłaty</span></p>
                  <ul class="list-group list-group-flush rounded-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0">Data wpłaty jednorazowej:</p>
                      <p class="mb-0">{{$entry->one_time_pay}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0">Data wpłaty I raty:</p>
                      <p class="mb-0">{{$entry->first_pay}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0">Data wpłaty II raty:</p>
                      <p class="mb-0">{{$entry->second_pay}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0">Data wpłaty III raty:</p>
                      <p class="mb-0">{{$entry->third_pay}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0">Data wpłaty IV raty:</p>
                      <p class="mb-0">{{$entry->forth_pay}}</p>
                    </li>   
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center m-4">
        <a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}">
        <button type="button" data-mdb-button-init="" data-mdb-ripple-init="" class="btn btn-primary" data-mdb-button-initialized="true">Edytuj profil</button>    

        </a>
      </div>
    </section>
</section>

@endsection

@section('after_content_widgets')
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'after_content')->toArray() ])
@endsection

