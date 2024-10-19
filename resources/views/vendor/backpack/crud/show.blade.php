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
              <h3 class="mb-2 mt-0"><span class="text-primary d-flex justify-content-center">Zdjęcie</span></h3>
               @if($entry->image_url)
              <img src="{{ asset('storage/'.$entry->image_url) }}" alt="avatar" class="rounded" style="max-height: 200px; height: 60%; width: auto">
            @else
              <img src="{{ asset('storage/photos/Blank-profile.png') }}" alt="no_avatar" class="rounded" style="max-height: 200px; height: 60%; width: auto">
            @endif
            </div>
          </div>
          <div class="card mb-4 mb-lg-0">
            <div class="card-body p-0">
              <h3 class="mb-2 mt-3"><span class="text-primary d-flex justify-content-center">Szczegóły adopcji</span></h3>
              <ul class="list-group list-group-flush rounded-3">
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <p class="mb-0 fw-bolder">Asystent:</p>
                  <p class="mb-0">{{$entry->coordinator_first_name .' '. $entry->coordinator_last_name}}</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <p class="mb-0 fw-bolder">Data rozpoczęcia:</p>
                  <p class="mb-0">{{$entry->adoption_start_date}}</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <p class="mb-0 fw-bolder">Data zakończenia:</p>
                  <p class="mb-0">{{$entry->adoption_end_date}}</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <p class="mb-0 fw-bolder">Czas trwania:</p>
                  <p class="mb-0">{{intval($entry->length_of_adoption/365)}} lat</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <p class="mb-0 fw-bolder">Pozostało:</p>
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
          <div class="d-flex justify-content-between m-4">
            <a href="{{ url($crud->route) }}">
            <button type="button" data-mdb-button-init="" data-mdb-ripple-init="" class="btn btn-secondary" data-mdb-button-initialized="true"><i class="las la-chevron-left"></i>&nbsp;Powrót</button>    
            </a>
            <a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}">
            <button type="button" data-mdb-button-init="" data-mdb-ripple-init="" class="btn btn-primary" data-mdb-button-initialized="true"><i class="las la-edit"></i>&nbsp;Edytuj profil</button>    
            </a>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="card mb-4">
            <div class="card-body">
              <h3 class="mb-3"><span class="text-primary d-flex justify-content-center">Dane dziecka</span></h3>
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0 fw-bolder">Imię:</p>
                </div>
                <div class="col-sm-9">
                  <p class="mb-0">{{ $entry->first_name }}</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0 fw-bolder">Nazwisko:</p>
                </div>
                <div class="col-sm-9">
                  <p class="mb-0"> {{ $entry->last_name }}</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0 fw-bolder">Numer ewidencji:</p>
                </div>
                <div class="col-sm-9">
                  <p class="mb-0"> {{ $entry->evidence_number }}</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0 fw-bolder">Wiek:</p>
                </div>
                <div class="col-sm-9">
                  <p class="mb-0">{{ $entry->age}} lat</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0 fw-bolder">Płeć:</p>
                </div>
                <div class="col-sm-9">
                  <p class="mb-0">{{ $entry->sex}}</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0 fw-bolder">Miejscowość:</p>
                </div>
                <div class="col-sm-9">
                  <p class="mb-0">{{ $entry->birth_place}}</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0 fw-bolder">Kraj:</p>
                </div>
                <div class="col-sm-9">
                  <p class="mb-0">{{ $entry->country}}</p>
                </div>
              </div> 
              <hr style="margin: 1rem 0;">   
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0 fw-bolder">Zgromadzenie:</p>
                </div>
                <div class="col-sm-9">
                  <p class="mb-0">{{ $entry->group}}</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">   
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0 fw-bolder">Uwagi:</p>
                </div>
                <div class="col-sm-9">
                  <p class="mb-0">{{ $entry->others}}</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="card mb-4 mb-md-0">
                <div class="card-body p-0">
                  <h3 class="mb-2 mt-3"><span class="text-primary d-flex justify-content-center">Dane opiekuna</span></h3>
                  <ul class="list-group list-group-flush rounded-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0 fw-bolder">Rodzaj opiekuna:</p>
                      <p class="mb-0">{{$entry->adopter_type}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0 fw-bolder">Nazwa:</p>
                      <p class="mb-0">{{$entry->adopter_type_name}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0 fw-bolder">Imię:</p>
                      <p class="mb-0">{{$entry->adopter_first_name}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0 fw-bolder">Nazwisko:</p>
                      <p class="mb-0"> {{$entry->adopter_last_name}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0 fw-bolder">Email:</p>
                      <p class="mb-0"> {{$entry->adopter_email}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0 fw-bolder">Telefon:</p>
                      <p class="mb-0"> {{$entry->adopter_phone}}</p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0 fw-bolder">Adres:</p>
                      <p class="mb-0"> {{$entry->adopter_address}}</p>
                    </li>   
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      <p class="mb-0 fw-bolder">Komandoria:</p>
                      <p class="mb-0">{{$entry->flag_comandory}}</p>
                    </li>               
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card mb-4 mb-md-0">
                <div class="card-body p-0">
                  <h3 class="mb-2 mt-3"><span class="text-primary d-flex justify-content-center">Wpłaty</span></h3>
                  <ul class="list-group list-group-flush rounded-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      @if ($entry->one_time_pay == null)
                      @else
                      <p class="mb-0 fw-bolder">Data wpłaty jednorazowej:</p>
                      <p class="mb-0">{{$entry->one_time_pay}}</p>
                      @endif
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      @if ($entry->first_pay == null)
                      @else
                      <p class="mb-0 fw-bolder">Data wpłaty I raty:</p>
                      <p class="mb-0">{{$entry->first_pay}}</p>
                      @endif
                    </li>
                     <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      @if ($entry->second_pay == null)
                      @else
                      <p class="mb-0 fw-bolder">Data wpłaty II raty:</p>
                      <p class="mb-0">{{$entry->second_pay}}</p>
                      @endif
                    </li>
                     <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      @if ($entry->third_pay == null)
                      @else
                      <p class="mb-0 fw-bolder">Data wpłaty III raty:</p>
                      <p class="mb-0">{{$entry->third_pay}}</p>
                      @endif
                    </li>
                     <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                      @if ($entry->forth_pay == null)
                      @else
                      <p class="mb-0 fw-bolder">Data wpłaty IV raty:</p>
                      <p class="mb-0">{{$entry->forth_pay}}</p>
                      @endif
                    </li>              
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     
    </section>
</section>

@endsection

@section('after_content_widgets')
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'after_content')->toArray() ])
@endsection

