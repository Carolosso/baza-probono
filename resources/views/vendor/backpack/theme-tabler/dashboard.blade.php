@extends(backpack_view('layouts.' . (backpack_theme_config('layout') ?? 'vertical')))

@php
	// Merge widgets that were fluently declared with widgets declared without the fluent syntax:
	// - $data['widgets']['before_content']
	// - $data['widgets']['after_content']
	/* if (isset($widgets)) {
		foreach ($widgets as $section => $widgetSection) {
			foreach ($widgetSection as $key => $widget) {
				\Backpack\CRUD\app\Library\Widget::add($widget)->section($section);
			}
		}
	} */

	Widget::add([
    'type'        => 'jumbotron',
    'heading'     => 'Witaj w panelu bazy danych!',
    //'content'     => 'My magnific headline! Lets build something awesome together.',
    //'button_link' => backpack_url('child'),
    //'button_text' => 'Lista dzieci',
    // OPTIONAL:
    'heading_class' => 'display-3',
	]);
	Widget::add([
    'type'        => 'progress',
    'class'       => 'card text-white bg-primary mb-2',
    'value'       => '2',
    'description' => 'Adoptowanych dzieci',
    //'progress'    => 57, // integer
    //'hint'        => '8544 more until next milestone.',
]);
@endphp

@section('before_breadcrumbs_widgets')
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'before_breadcrumbs')->toArray() ])
@endsection

@section('after_breadcrumbs_widgets')
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'after_breadcrumbs')->toArray() ])
@endsection

@section('before_content_widgets')
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'before_content')->toArray() ])
@endsection

@section('content')



@endsection

@section('after_content_widgets')
	@include(backpack_view('inc.widgets'), [ 'widgets' => app('widgets')->where('section', 'after_content')->toArray() ])
@endsection