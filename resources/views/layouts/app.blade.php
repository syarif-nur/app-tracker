
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>App Tracker</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-30 w-full">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-2">
                    <button class="lg:hidden h-10 w-10 flex items-center justify-center rounded-md text-gray-500 hover:text-blue-700 hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500" @click="sidebarOpen = true" aria-label="Open sidebar">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <span class="text-xl font-bold text-blue-700 tracking-tight"> App Tracker</span>
                </div>
                <div class="flex items-center gap-4">
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 px-2 py-1 hover:bg-blue-50 transition min-w-[44px] min-h-[44px]">
                            <span class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-blue-600 text-white font-semibold text-base">
                                {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                            </span>
                            <svg class="h-4 w-4 text-gray-400 ml-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50 overflow-hidden">
                            <div class="px-4 py-3">
                                <p class="text-sm text-gray-500">Signed in as</p>
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                            </div>
                            <div class="py-1">
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <svg class="mr-3 h-4 w-4 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Sign out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex flex-1 min-h-0">
            <!-- Sidebar -->
            <aside :class="{'-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen}" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-gray-200 shadow-xl transform lg:translate-x-0 lg:static lg:inset-0 transition-all duration-300 ease-in-out flex flex-col">
                <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 bg-gradient-to-r from-blue-600 to-blue-700">
                    <span class="font-bold text-xl text-white">Menu</span>
                    <button class="lg:hidden text-white hover:bg-blue-800 p-1 rounded" @click="sidebarOpen = false">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <nav class="flex-1 px-3 py-6 overflow-y-auto">
                    @php
                        // Always get $menus from Livewire AppLayout if available
                        $menus = $menus ?? (\Livewire\Livewire::isLivewireRequest() ? ($menus ?? []) : (isset($menus) ? $menus : []));
                    @endphp
                    @if(isset($menus) && count($menus))
                        @foreach($menus as $menu)
                            <a href="{{ $menu['route'] ?? $menu->route }}" class="group flex items-center px-4 py-3 mb-1 text-sm font-medium rounded-lg transition-all duration-200 {{ request()->is(ltrim($menu['route'] ?? $menu->route, '/')) ? 'bg-blue-50 text-blue-700 border-r-4 border-blue-600' : 'text-gray-700 hover:bg-gray-50 hover:text-blue-600' }}">
                                @if(isset($menu['icon']) || isset($menu->icon))
                                    <span class="mr-3">
                                        <i class="{{ $menu['icon'] ?? $menu->icon }}"></i>
                                    </span>
                                @endif
                                <span class="truncate">{{ $menu['name'] ?? $menu->name }}</span>
                            </a>
                        @endforeach
                    @else
                        <div class="px-4 py-3 text-sm text-gray-500">No menu available</div>
                    @endif
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 flex flex-col min-h-0">
                <div class="flex-1 overflow-y-auto p-6">
                    {{ $slot }}
                </div>
                <!-- Footer -->
                <footer class="bg-white border-t border-gray-200 py-4 text-center text-sm text-gray-500">
                    &copy; {{ date('Y') }} App Tracker. All rights reserved.
                </footer>
            </main>
        </div>
    </div>
    @stack('modals')
    @livewireScripts
</body>
</html>
