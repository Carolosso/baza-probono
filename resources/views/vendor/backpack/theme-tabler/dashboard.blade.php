@extends(backpack_view('layouts.' . (backpack_theme_config('layout') ?? 'vertical')))

@php
use App\Models\Child;

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
        $childrenCount = Child::count();

	Widget::add([
    'type'        => 'jumbotron',
    'heading'     => 'Witaj w panelu bazy danych!',
    //'content'     => 'My magnific headline! Lets build something awesome together.',
    //'button_link' => backpack_url('child'),
    //'button_text' => 'Lista dzieci',
    // OPTIONAL:
    'heading_class' => 'display-4',
	]);

	Widget::add([
    'type'        => 'card',
    'class'       => 'card text-white bg-primary mb-2',
    'content' => [
		'header' =>'Dodanych dzieci',
		'body' => $childrenCount,
	]]);
	Widget::add([
    'type'        => 'card',
    'class'       => 'card text-white bg-danger mb-2',
    'content' => [
		'header' =>'Uwaga!',
		'body' => 'Proszę o sprawdzenie okresu adopcji ostatnio edytowanych dzieci. Występował błąd, który mógł nieoczekiwanie zmieniać okres adopcji na 1 rok.',
	]]);

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