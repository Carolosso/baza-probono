{{-- This file is used for menu items by any Backpack v6 theme --}}
{{-- <x-backpack::menu-item title="Payments" icon="la la-question" :link="backpack_url('payment')" /> --}}
<x-backpack::menu-item title="{{ trans('backpack::base.dashboard') }}" icon="la la-home nav-icon" :link="backpack_url('dashboard')" />
<x-backpack::menu-item title="Deklaracje" icon="la la-address-book nav-icon" :link="backpack_url('declaration')" />
<x-backpack::menu-item title="Dzieci" icon="la la-child nav-icon" :link="backpack_url('child')" />
<x-backpack::menu-item title="Opiekunowie" icon="la la-user-alt nav-icon" :link="backpack_url('adopter')" />
<x-backpack::menu-dropdown title="Inne" icon="la la-users-cog">
    <x-backpack::menu-dropdown-item title="Asystenci" icon="la la-user-tie nav-icon" :link="backpack_url('assistant')" />
    <x-backpack::menu-dropdown-item title="Komandorie" icon="la la-flag nav-icon" :link="backpack_url('commandory')" />
    <x-backpack::menu-dropdown-item title="Zgromadzenia" icon="la la-group nav-icon" :link="backpack_url('group')" />
</x-backpack::menu-dropdown>

{{-- Only show this dropdown if the user has the Admin role --}}
@if (backpack_user() && backpack_user()->hasRole('Administrator'))
    <x-backpack::menu-dropdown title="Dostęp" icon="la la-shield">
        <x-backpack::menu-dropdown-item title="Użytkownicy" icon="la la-user-shield" :link="backpack_url('user')" />
        <x-backpack::menu-dropdown-item title="Role" icon="la la-group" :link="backpack_url('role')" />
        <x-backpack::menu-dropdown-item title="Uprawnienia" icon="la la-key" :link="backpack_url('permission')" />
    </x-backpack::menu-dropdown>
@endif
