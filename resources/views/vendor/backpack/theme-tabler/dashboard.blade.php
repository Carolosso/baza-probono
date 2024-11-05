@extends(backpack_view('layouts.' . (backpack_theme_config('layout') ?? 'vertical')))

@php
use App\Models\Child;
use App\Models\Commandory;

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
    'heading_class' => 'display-4',
	]);

	Widget::add([
		'type' => 'div',
		'class' => 'row',
		'content' => [
			[
				'type' => 'card',
				'class'       => 'card text-white bg-primary mb-2',
				'content' => [
						'header' =>'<i class="la la-users"></i>&nbsp;Dodanych dzieci',
						'body' => '<h2>'.Child::count().'</h2>',
					],
				'wrapper' => ['class'=>'col-md-4']
			],
			[
				'type' => 'card',
				'class' => 'card text-white bg-secondary mb-2',
				'content' => [
						'header' =>'<i class="la la-flag"></i>&nbsp;Liczba komandorii',
						'body' => '<h2>'.Commandory::count().'</h2>',
					],
				'wrapper' => ['class'=>'col-md-4']
			],
		]
	]);

	Widget::add([
		'type'        => 'card',
		'class'       => 'card text-white bg-warning mb-2',
		'content' => [
			'header' =>'Informacja',
			'body' => '
				<ul>Przywrócono z kopii zapasowej wpisy dzieci (bez zdjęć i wpłat):
					<li>Cezar</li>
					<li>Joel Suika Sangnyuy</li>
					<li>Keith Delos Santos</li>
					<li>Kristian</li>
				</ul> ',
			],
		'wrapper' => ['class'=>'col-md-8']
	]);

				
	Widget::add([
		'type'	=> 'custom_collapse_widget',
		'class'	=> 'card text-white bg-dark mb-2',
		'title' =>	'Zmiany 29.10.2024 ',
		 //<span class="mx-2 badge badge-secondary">Nowe</span>
		'content' => '
			<ul>
				<li>Dodano opcję szukania w rozwijanych listach (komandorie i państwa)</li>
				<li>Drobne poprawki i zmiany</li>
			</ul> ',
		'number' => '4',
		'wrapper' => 'col-md-8'
	]);

	Widget::add([
		'type'	=> 'custom_collapse_widget',
		'class'	=> 'card text-white bg-dark mb-2',
		'title' =>	'Zmiany 26.10.2024',
		'content' => '
			<ul>Przebudowanie części systemu, tj.
				<li>Utworzenie odrębnego obiektu dla wpłat, co umożliwia dynamiczne dodawanie i przypisywanie wpłat do aktualnie wybranego dziecka</li>
				<li>Utworzenie odrębnego obiektu dla komandorii, co umożliwia dodawanie nowych komandorii a następnie przypisywanie dziecka do danej komandorii</li>
				<li>Uzupełnienie listy wspólnot (salezjanie,pallotyni,franciszkanki od Cierpiących,kanoniczki (duchaczki))</li>
				<li>Przebudowa opcji "okresu adopcji", dająca możliwość wpisania dowolnej wartości</li>
				<li>Zwiększenie liczby domyślnie wyświetlanych rekordów z 10 na 20</li>
				<li>Drobne poprawki i optymalizacje</li>
			</ul> ',
		'number' => '3',
		'wrapper' => 'col-md-8'
	]);
	Widget::add([
		'type'	=> 'custom_collapse_widget',
		'class'	=> 'card text-white bg-dark mb-2',
		'title' =>	'Zmiany 19.10.2024',
		'content' => '
			<ul>
				<li>3 tryby eksportu danych</li>
				<li>Uzupełnienie listy "Rodzaje opiekunów" (Ksiądz, Siostra Zakonna, Ojciec Zakonny, Wspólnota parafialna, Szkoła, Urząd)</li>
				<li>Uzupełnienie listy komandorii (paryska)</li>
				<li>Dodano nowe dynamiczne pole "Nazwa" w zakładce Dane opiekuna</li>
				<li>Dodano nowe statyczne pole "Numer ewidencji" w zakładce Dane dziecka</li>
				<li>Dodano generowanie Daty zakończenia adopcji</li>
				<li>Drobne poprawki i optymalizacje</li>
			</ul> ',
		'number' => '2',
		'wrapper' => 'col-md-8'
	]);
	Widget::add([
		'type'	=> 'custom_collapse_widget',
		'class'	=> 'card text-white bg-dark mb-2',
		'title' =>	'Zmiany 18.10.2024',
		'content' => '
			<ul>Dodano:
				<li>Podstawowe filtrowanie</li>
				<li>Eksport danych do pliku w formacie CSV</li>
			</ul> ',
		'number' => '1',
		'wrapper' => 'col-md-8'
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