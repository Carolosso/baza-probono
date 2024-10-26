@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.list') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
  use App\Models\Commandory;

  $commandories = Commandory::orderBy('commandory_name', 'asc')->get();
@endphp

@section('header')
    <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
        <h1 class="text-capitalize mb-0" bp-section="page-heading">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h1>
        <p class="ms-2 ml-2 mb-0" id="datatable_info_stack" bp-section="page-subheading">{!! $crud->getSubheading() ?? '' !!}</p>
    </section>
@endsection

@section('content')
  {{-- Default box --}}
  <div class="row" bp-section="crud-operation-list">

    {{-- THE ACTUAL CONTENT --}}
    <div class="{{ $crud->getListContentClass() }}">

        <div class="row mb-2 align-items-center">
          <div class="col-sm-9">
            @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
              <div class="d-print-none {{ $crud->hasAccess('create')?'with-border':'' }}">

                @include('crud::inc.button_stack', ['stack' => 'top'])

              </div>
            @endif
          </div>
        </div>
@if (Request::is('admin/child*'))
<hr class="my-3 p-0">
<form method="GET" action="{{ url($crud->route) }}">
    <div class="row mb-3">
        <div class="col-md-1 align-self-center">
            Płeć:
        </div>
        <div class="col-md-2">
            <select name="sex" class="form-control">
                <option value="">wszystkie</option>
                <option value="mężczyzna" {{ request()->input('sex') == 'mężczyzna' ? 'selected' : '' }}>mężczyzna</option>
                <option value="kobieta" {{ request()->input('sex') == 'kobieta' ? 'selected' : '' }}>kobieta</option>
            </select>
        </div>
        <div class="col-md-1 align-self-center">
            Zgromadzenie:
        </div>
        <div class="col-md-2">
            <select name="group" class="form-control">
                <option value="">wszystkie</option>
                <option value="michalitki" {{ request()->input('group') == 'michalitki' ? 'selected' : '' }}>michalitki</option>
                <option value="pasjonistki" {{ request()->input('group') == 'pasjonistki' ? 'selected' : '' }}>pasjonistki</option>
                <option value="klawerianki" {{ request()->input('group') == 'klawerianki' ? 'selected' : '' }}>klawerianki</option>
                <option value="opatrzności bożej" {{ request()->input('group') == 'opatrzności bożej' ? 'selected' : '' }}>opatrzności bożej</option>
                <option value="urszulanki" {{ request()->input('group') == 'urszulanki' ? 'selected' : '' }}>urszulanki</option>
                <option value="franciszkanie" {{ request()->input('group') == 'franciszkanie' ? 'selected' : '' }}>franciszkanie</option>
                <option value="salezjanie" {{ request()->input('group') == 'salezjanie' ? 'selected' : '' }}>salezjanie</option>
                <option value="pallotyni" {{ request()->input('group') == 'pallotyni' ? 'selected' : '' }}>pallotyni</option>
                <option value="franciszkanki od Cierpiących" {{ request()->input('group') == 'franciszkanki od Cierpiących' ? 'selected' : '' }}>franciszkanki od Cierpiących</option>
                <option value="kanoniczki (duchaczki)" {{ request()->input('group') == 'kanoniczki (duchaczki)' ? 'selected' : '' }}>kanoniczki (duchaczki)</option>
            </select>
        </div>
            <div class="col-md-1 align-self-center">
                Komandoria:
            </div>
            <div class="col-md-2">
              
            <select name="commandory_id" class="form-control">
              <option value="">wszystkie</option>  <!-- Default "all" option -->
              
              @foreach ($commandories as $commandory)
                  <option value="{{ $commandory->id }}" 
                      {{ request()->input('commandory_id') == $commandory->id ? 'selected' : '' }}>
                      {{ $commandory->commandory_name }}
                  </option>
              @endforeach
          </select>

        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary"><i class="las la-filter"></i>&nbsp;Filtruj</button>
        </div>

         @if($crud->getOperationSetting('searchableTable'))
          <div class="col-sm-2">
            <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none">
              <div class="input-icon">
                <span class="input-icon-addon">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                </span>
                <input type="search" class="form-control" placeholder="{{ trans('backpack::crud.search') }}..."/>
              </div>
            </div>
          </div>
          @endif
    </div>
    <!-- CSV export button -->
    <div class="row">
      <div class="col-md-2 btn-group dropend">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true" title="Eksportuj pola na podstawie wybranych filtrów">
          <i class="las la-save"></i>&nbsp;Eksportuj do CSV
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
          <li><button type="submit" class="btn dropdown-item" formaction="{{ route('child.export-csvAll') }}">Wszystko</button></li>
          <li><button type="submit" class="btn dropdown-item" formaction="{{ route('child.export-csvChild') }}">Dane dzieci</button></li>
          <li><button type="submit" class="btn dropdown-item" formaction="{{ route('child.export-csvAdopter') }}">Dane opiekunów</button></li>
        </ul>
      </div>
    </div>
</form>

<hr class="my-3 p-0">
@else
         @if($crud->getOperationSetting('searchableTable'))
          <div class="col-sm-2">
            <div id="datatable_search_stack" class="mt-sm-0 mt-2 d-print-none">
              <div class="input-icon">
                <span class="input-icon-addon">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path><path d="M21 21l-6 -6"></path></svg>
                </span>
                <input type="search" class="form-control" placeholder="{{ trans('backpack::crud.search') }}..."/>
              </div>
            </div>
          </div>
          @endif
@endif

        {{-- Backpack List Filters
        @if ($crud->filtersEnabled())
          @include('crud::inc.filters_navbar')
        @endif --}}

        <div class="{{ backpack_theme_config('classes.tableWrapper') }}">
            <table
              id="crudTable"
              class="{{ backpack_theme_config('classes.table') ?? 'table table-striped table-hover nowrap rounded card-table table-vcenter card d-table shadow-xs border-xs' }}"
              data-responsive-table="{{ (int) $crud->getOperationSetting('responsiveTable') }}"
              data-has-details-row="{{ (int) $crud->getOperationSetting('detailsRow') }}"
              data-has-bulk-actions="{{ (int) $crud->getOperationSetting('bulkActions') }}"
              data-has-line-buttons-as-dropdown="{{ (int) $crud->getOperationSetting('lineButtonsAsDropdown') }}"
              data-line-buttons-as-dropdown-minimum="{{ (int) $crud->getOperationSetting('lineButtonsAsDropdownMinimum') }}"
              data-line-buttons-as-dropdown-show-before-dropdown="{{ (int) $crud->getOperationSetting('lineButtonsAsDropdownShowBefore') }}"
              cellspacing="0">
            <thead>
              <tr>
                {{-- Table columns --}}
                @foreach ($crud->columns() as $column)
                  @php
                  $exportOnlyColumn = $column['exportOnlyColumn'] ?? false;
                  $visibleInTable = $column['visibleInTable'] ?? ($exportOnlyColumn ? false : true);
                  $visibleInModal = $column['visibleInModal'] ?? ($exportOnlyColumn ? false : true);
                  $visibleInExport = $column['visibleInExport'] ?? true;
                  $forceExport = $column['forceExport'] ?? (isset($column['exportOnlyColumn']) ? true : false);
                  @endphp
                  <th
                    data-orderable="{{ var_export($column['orderable'], true) }}"
                    data-priority="{{ $column['priority'] }}"
                    data-column-name="{{ $column['name'] }}"
                    {{--
                    data-visible-in-table => if developer forced column to be in the table with 'visibleInTable => true'
                    data-visible => regular visibility of the column
                    data-can-be-visible-in-table => prevents the column to be visible into the table (export-only)
                    data-visible-in-modal => if column appears on responsive modal
                    data-visible-in-export => if this column is exportable
                    data-force-export => force export even if columns are hidden
                    --}}

                    data-visible="{{ $exportOnlyColumn ? 'false' : var_export($visibleInTable) }}"
                    data-visible-in-table="{{ var_export($visibleInTable) }}"
                    data-can-be-visible-in-table="{{ $exportOnlyColumn ? 'false' : 'true' }}"
                    data-visible-in-modal="{{ var_export($visibleInModal) }}"
                    data-visible-in-export="{{ $exportOnlyColumn ? 'true' : ($visibleInExport ? 'true' : 'false') }}"
                    data-force-export="{{ var_export($forceExport) }}"
                  >
                    {{-- Bulk checkbox --}}
                    @if($loop->first && $crud->getOperationSetting('bulkActions'))
                      {!! View::make('crud::columns.inc.bulk_actions_checkbox')->render() !!}
                    @endif
                    {!! $column['label'] !!}
                  </th>
                @endforeach

                @if ( $crud->buttons()->where('stack', 'line')->count() )
                  <th data-orderable="false"
                      data-priority="{{ $crud->getActionsColumnPriority() }}"
                      data-visible-in-export="false"
                      data-action-column="true"
                      >{{ trans('backpack::crud.actions') }}</th>
                @endif
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                {{-- Table columns --}}
                @foreach ($crud->columns() as $column)
                  <th>
                    {{-- Bulk checkbox --}}
                    @if($loop->first && $crud->getOperationSetting('bulkActions'))
                      {!! View::make('crud::columns.inc.bulk_actions_checkbox')->render() !!}
                    @endif
                    {!! $column['label'] !!}
                  </th>
                @endforeach

                @if ( $crud->buttons()->where('stack', 'line')->count() )
                  <th>{{ trans('backpack::crud.actions') }}</th>
                @endif
              </tr>
            </tfoot>
          </table>
        </div>

        @if ( $crud->buttons()->where('stack', 'bottom')->count() )
            <div id="bottom_buttons" class="d-print-none text-sm-left">
                @include('crud::inc.button_stack', ['stack' => 'bottom'])
                <div id="datatable_button_stack" class="float-right float-end text-right hidden-xs"></div>
            </div>
        @endif

    </div>

  </div>

@endsection

@section('after_styles')
  {{-- DATA TABLES --}}
  @basset('https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css')
  @basset('https://cdn.datatables.net/fixedheader/3.3.1/css/fixedHeader.dataTables.min.css')
  @basset('https://cdn.datatables.net/responsive/2.4.0/css/responsive.dataTables.min.css')

  {{-- CRUD LIST CONTENT - crud_list_styles stack --}}
  @stack('crud_list_styles')
@endsection

@section('after_scripts')
  @include('crud::inc.datatables_logic')

  {{-- CRUD LIST CONTENT - crud_list_scripts stack --}}
  @stack('crud_list_scripts')
@endsection
