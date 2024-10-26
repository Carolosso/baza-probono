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

/* 	Widget::add([
    'type'        => 'card',
    'class'       => 'card text-white bg-danger mb-2',
    'content' => [
		'header' =>'Uwaga!',
		'body' => 'Proszę o sprawdzenie okresu adopcji ostatnio edytowanych dzieci. Występował błąd, który mógł nieoczekiwanie zmieniać okres adopcji na 1 rok.',
	]]); */

	Widget::add([
    'type'        => 'card',
    'class'       => 'card text-white bg-dark mb-2',
    'content' => [
		'header' =>'Zmiany 26.10.2024!',
		'body' => '
			<ul>Przebudowanie części systemu, tj.
				<li>Utworzenie odrębnego obiektu dla wpłat, co umożliwia dynamiczne dodawanie i przypisywanie wpłat do aktualnie wybranego dziecka</li>
				<li>Utworzenie odrębnego obiektu dla komandorii, co umożliwia dodawanie nowych komandorii a następnie przypisywanie dziecka do danej komandorii</li>
				<li>Uzupełnienie listy wspólnot (salezjanie,pallotyni,franciszkanki od Cierpiących,kanoniczki (duchaczki))</li>
				<li>Przebudowa opcji "okresu adopcji", dająca możliwość wpisania dowolnej wartości</li>
				<li>Zwiększenie liczby domyślnie wyświetlanych rekordów z 10 na 20</li>
				<li>Drobne poprawki i optymalizacje</li>
			</ul> ',
	]]);

	Widget::add([
    'type'        => 'card',
    'class'       => 'card text-white bg-dark mb-2',
    'content' => [
		'header' =>'Zmiany 19.10.2024',
		'body' => '
			<ul>
				<li>3 tryby eksportu danych</li>
				<li>Uzupełnienie listy "Rodzaje opiekunów" (Ksiądz, Siostra Zakonna, Ojciec Zakonny, Wspólnota parafialna, Szkoła, Urząd)</li>
				<li>Uzupełnienie listy komandorii (paryska)</li>
				<li>Dodano nowe dynamiczne pole "Nazwa" w zakładce Dane opiekuna</li>
				<li>Dodano nowe statyczne pole "Numer ewidencji" w zakładce Dane dziecka</li>
				<li>Dodano generowanie Daty zakończenia adopcji</li>
				<li>Drobne poprawki i optymalizacje</li>
			</ul> ',
	]]);

	Widget::add([
    'type'        => 'card',
    'class'       => 'card text-white bg-dark mb-2',
    'content' => [
		'header' =>'Zmiany 18.10.2024',
		'body' => '
			<ul>Dodano:
				<li>Podstawowe filtrowanie</li>
				<li>Eksport danych do pliku w formacie CSV</li>
			</ul> ',
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