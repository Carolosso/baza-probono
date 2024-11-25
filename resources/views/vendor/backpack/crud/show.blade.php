@extends(backpack_view('layouts.' . (backpack_theme_config('layout') ?? 'vertical')))


@if (Request::is('admin/child*'))
@php
  $breadcrumbs = [
      'Panel główny' => backpack_url('dashboard'),
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
                  <p class="mb-0 fw-bolder">Okres adopcji:</p>
                  <p class="mb-0">{{$entry->type_of_adoption}}</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <p class="mb-0 fw-bolder">Czas trwania:</p>
                  <p class="mb-0">{{intval($entry->length_of_adoption/365)}} lat</p>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                  <p class="mb-0 fw-bolder">Pozostało:</p>
                  <p class="mb-0">
                    @if (!$entry->adopter_id)
                      <span class="badge bg-grey text-red-fg">Brak opiekuna</span>
                    @elseif($entry->remaining_days_of_adoption<1)
                      <span class="badge bg-red text-red-fg">Wygasło</span>
                    @elseif ($entry->remaining_days_of_adoption>= 1 && $entry->remaining_days_of_adoption< 30)
                      <span class="badge bg-orange text-orange-fg"> {{$entry->remaining_days_of_adoption}} dni</span>
                    @elseif ($entry->remaining_days_of_adoption>= 30 && $entry->remaining_days_of_adoption <= 90)
                      <span class="badge bg-yellow text-yellow-fg"> {{$entry->remaining_days_of_adoption}} dni</span>
                    @else <span class="badge bg-green text-green-fg ">{{$entry->remaining_days_of_adoption}} dni</span>
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
              <hr style="margin: 1rem 0;">   
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Utworzono:</p>
                </div>
                <div class="col-sm-9">
                  <p class="mb-0">{{ $entry->created_at}}</p>
                </div>
              </div>
              <hr style="margin: 1rem 0;">   
              <div class="row">
                <div class="col-sm-3">
                  <p class="mb-0">Ostatnia modyfikacja:</p>
                </div>
                <div class="col-sm-9">
                  <p class="mb-0">{{ $entry->updated_at}}</p>
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
                      <p class="mb-0">{{$entry->commandory_name}}</p>
                    </li>               
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6 ">
              <div class="card mb-4 mb-md-0">
                <div class="card-body p-0">
                  <h3 class="mb-2 mt-3"><span class="text-primary d-flex justify-content-center">Wpłaty</span></h3>
                   @if($entry->payments->isEmpty())
                          <p class="p-3">Nie znaleziono wpłat.</p>
                      @else
                          <ul class="list-group">
                              @foreach($entry->payments as $payment)
                                  <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                      <div>
                                          <strong>Kwota:</strong> {{ $payment->payment_amount }} zł<br>
                                          <strong>Data:</strong> {{ $payment->payment_date}}<br>
                                          <strong>Opis:</strong> {{ $payment->payment_description}}
                                      </div>
                                  </li>
                              @endforeach
                          </ul>
                      @endif
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
     
    </section>
</section>

@endsection
@elseif (Request::is('admin/adopter*') or Request::is('admin/declaration*'))
@php
    $defaultBreadcrumbs = [
      'Start' => url(config('backpack.base.route_prefix'), 'dashboard'),
      $crud->entity_name_plural => url($crud->route),
      trans('backpack::crud.preview') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp
@section('header')
    <div class="container-fluid d-flex justify-content-between my-3">
        <section class="header-operation animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
            <h1 class="text-capitalize mb-0" bp-section="page-heading">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h1>
            <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">{!! $crud->getSubheading() ?? mb_ucfirst(trans('backpack::crud.preview')).' '.$crud->entity_name !!}</p>
            @if ($crud->hasAccess('list'))
                <p class="ms-2 ml-2 mb-0" bp-section="page-subheading-back-button">
                    <small><a href="{{ url($crud->route) }}" class="font-sm"><i class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
                </p>
            @endif
        </section>
        <a href="javascript: window.print();" class="btn float-end float-right"><i class="la la-print"></i></a>
    </div>
@endsection

@section('content')
<div class="row" bp-section="crud-operation-show">
    <div class="{{ $crud->getShowContentClass() }}">

	{{-- Default box --}}
	<div class="">
	@if ($crud->model->translationEnabled())
		<div class="row">
			<div class="col-md-12 mb-2">
				{{-- Change translation button group --}}
				<div class="btn-group float-right">
				<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('_locale')?request()->input('_locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					@foreach ($crud->model->getAvailableLocales() as $key => $locale)
						<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?_locale={{ $key }}">{{ $locale }}</a>
					@endforeach
				</ul>
				</div>
			</div>
		</div>
	@endif
		@if($crud->tabsEnabled() && count($crud->getUniqueTabNames('columns')))
			@include('crud::inc.show_tabbed_table')
		@else
			<div class="card no-padding no-border mb-0">
				@include('crud::inc.show_table', ['columns' => $crud->columns()])
			</div>
		@endif
	</div>
	</div>
</div>
@endsection
@endif


@section('after_content_widgets')
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'after_content')->toArray() ])
@endsection

