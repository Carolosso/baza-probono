{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('child') }}"><i class="la la-users nav-icon"></i>Lista dzieci</a></li>
{{-- <x-backpack::menu-item title="Payments" icon="la la-question" :link="backpack_url('payment')" /> --}}
<x-backpack::menu-item title="Komandorie" icon="la la-flag" :link="backpack_url('commandory')" />