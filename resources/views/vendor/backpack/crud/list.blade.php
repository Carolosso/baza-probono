@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.list') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
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
            </select>
        </div>
            <div class="col-md-1 align-self-center">
                Komandoria:
            </div>
            <div class="col-md-2">
            <select name="flag_comandory" class="form-control">
                <option value="">wszystkie</option>
                <option value="białostocka" {{ request()->input('flag_comandory') == 'białostocka' ? 'selected' : '' }}>białostocka</option>
                <option value="bielsko-żywiecka" {{ request()->input('flag_comandory') == 'bielsko-żywiecka' ? 'selected' : '' }}>bielsko-żywiecka</option>
                <option value="bydgoska" {{ request()->input('flag_comandory') == 'bydgoska' ? 'selected' : '' }}>bydgoska</option>
                <option value="częstochowska" {{ request()->input('flag_comandory') == 'częstochowska' ? 'selected' : '' }}>częstochowska</option>
                <option value="drohiczyńska" {{ request()->input('flag_comandory') == 'drohiczyńska' ? 'selected' : '' }}>drohiczyńska</option>
                <option value="elbląska" {{ request()->input('flag_comandory') == 'elbląska' ? 'selected' : '' }}>elbląska</option>
                <option value="ełcka" {{ request()->input('flag_comandory') == 'ełcka' ? 'selected' : '' }}>ełcka</option>
                <option value="gdańska" {{ request()->input('flag_comandory') == 'gdańska' ? 'selected' : '' }}>gdańska</option>
                <option value="gliwicka" {{ request()->input('flag_comandory') == 'gliwicka' ? 'selected' : '' }}>gliwicka</option>
                <option value="gnieźnieńska" {{ request()->input('flag_comandory') == 'gnieźnieńska' ? 'selected' : '' }}>gnieźnieńska</option>
                <option value="kaliska" {{ request()->input('flag_comandory') == 'kaliska' ? 'selected' : '' }}>kaliska</option>
                <option value="katowicka" {{ request()->input('flag_comandory') == 'katowicka' ? 'selected' : '' }}>katowicka</option>
                <option value="kielecka" {{ request()->input('flag_comandory') == 'kielecka' ? 'selected' : '' }}>kielecka</option>
                <option value="koszalińsko-kołobrzeska" {{ request()->input('flag_comandory') == 'koszalińsko-kołobrzeska' ? 'selected' : '' }}>koszalińsko-kołobrzeska</option>
                <option value="krakowska" {{ request()->input('flag_comandory') == 'krakowska' ? 'selected' : '' }}>krakowska</option>
                <option value="legnicka" {{ request()->input('flag_comandory') == 'legnicka' ? 'selected' : '' }}>legnicka</option>
                <option value="lubelska" {{ request()->input('flag_comandory') == 'lubelska' ? 'selected' : '' }}>lubelska</option>
                <option value="łomżyńska" {{ request()->input('flag_comandory') == 'łomżyńska' ? 'selected' : '' }}>łomżyńska</option>
                <option value="łowicka" {{ request()->input('flag_comandory') == 'łowicka' ? 'selected' : '' }}>łowicka</option>
                <option value="łódzka" {{ request()->input('flag_comandory') == 'łódzka' ? 'selected' : '' }}>łódzka</option>
                <option value="warmińska" {{ request()->input('flag_comandory') == 'warmińska' ? 'selected' : '' }}>warmińska</option>
                <option value="opolska" {{ request()->input('flag_comandory') == 'opolska' ? 'selected' : '' }}>opolska</option>
                <option value="pelplińska" {{ request()->input('flag_comandory') == 'pelplińska' ? 'selected' : '' }}>pelplińska</option>
                <option value="płocka" {{ request()->input('flag_comandory') == 'płocka' ? 'selected' : '' }}>płocka</option>
                <option value="poznańska" {{ request()->input('flag_comandory') == 'poznańska' ? 'selected' : '' }}>poznańska</option>
                <option value="przemyska" {{ request()->input('flag_comandory') == 'przemyska' ? 'selected' : '' }}>przemyska</option>
                <option value="radomska" {{ request()->input('flag_comandory') == 'radomska' ? 'selected' : '' }}>radomska</option>
                <option value="rzeszowska" {{ request()->input('flag_comandory') == 'rzeszowska' ? 'selected' : '' }}>rzeszowska</option>
                <option value="sandomierska" {{ request()->input('flag_comandory') == 'sandomierska' ? 'selected' : '' }}>sandomierska</option>
                <option value="siedlecka" {{ request()->input('flag_comandory') == 'siedlecka' ? 'selected' : '' }}>siedlecka</option>
                <option value="sosnowiecka" {{ request()->input('flag_comandory') == 'sosnowiecka' ? 'selected' : '' }}>sosnowiecka</option>
                <option value="szczecińsko-kamieńska" {{ request()->input('flag_comandory') == 'szczecińsko-kamieńska' ? 'selected' : '' }}>szczecińsko-kamieńska</option>
                <option value="świdnicka" {{ request()->input('flag_comandory') == 'świdnicka' ? 'selected' : '' }}>świdnicka</option>
                <option value="tarnowska" {{ request()->input('flag_comandory') == 'tarnowska' ? 'selected' : '' }}>tarnowska</option>
                <option value="toruńska" {{ request()->input('flag_comandory') == 'toruńska' ? 'selected' : '' }}>toruńska</option>
                <option value="warszawska" {{ request()->input('flag_comandory') == 'warszawska' ? 'selected' : '' }}>warszawska</option>
                <option value="warszawsko-praska" {{ request()->input('flag_comandory') == 'warszawsko-praska' ? 'selected' : '' }}>warszawsko-praska</option>
                <option value="włocławska" {{ request()->input('flag_comandory') == 'włocławska' ? 'selected' : '' }}>włocławska</option>
                <option value="wrocławska" {{ request()->input('flag_comandory') == 'wrocławska' ? 'selected' : '' }}>wrocławska</option>
                <option value="zamojsko-lubaczowska" {{ request()->input('flag_comandory') == 'zamojsko-lubaczowska' ? 'selected' : '' }}>zamojsko-lubaczowska</option>
                <option value="zielonogórsko-gorzowska" {{ request()->input('flag_comandory') == 'zielonogórsko-gorzowska' ? 'selected' : '' }}>zielonogórsko-gorzowska</option>
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
      <div class="col-md-4">
        <button type="submit" class="btn btn-secondary" formaction="{{ route('child.export-csv') }}"><i class="las la-save"></i>&nbsp;Eksportuj do CSV</button>
      </div>
    </div>
</form>

<hr class="my-3 p-0">

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
