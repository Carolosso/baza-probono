{{-- This file is used for menu items by any Backpack v6 theme --}}
{{-- <x-backpack::menu-item title="Payments" icon="la la-question" :link="backpack_url('payment')" /> --}}
<x-backpack::menu-item title="{{ trans('backpack::base.dashboard') }}" icon="la la-home nav-icon" :link="backpack_url('dashboard')" />
<x-backpack::menu-item title="Dzieci" icon="la la-group nav-icon" :link="backpack_url('child')" />
<x-backpack::menu-item title="Opiekunowie" icon="la la-user nav-icon" :link="backpack_url('adopter')" />
<x-backpack::menu-item title="Komandorie" icon="la la-flag" :link="backpack_url('commandory')" />
{{--<x-backpack::menu-item title="Adopters" icon="la la-question" :link="backpack_url('adopter')" /> --}}

{{-- Only show this dropdown if the user has the Admin role --}}
@if (backpack_user() && backpack_user()->hasRole('Administrator'))
    <x-backpack::menu-dropdown title="Dostęp" icon="la la-shield">
        {{-- <x-backpack::menu-dropdown-header title="Authentication" /> --}}
        <x-backpack::menu-dropdown-item title="Użytkownicy" icon="la la-user" :link="backpack_url('user')" />
        <x-backpack::menu-dropdown-item title="Role" icon="la la-group" :link="backpack_url('role')" />
        <x-backpack::menu-dropdown-item title="Uprawnienia" icon="la la-key" :link="backpack_url('permission')" />
    </x-backpack::menu-dropdown>
@endif
