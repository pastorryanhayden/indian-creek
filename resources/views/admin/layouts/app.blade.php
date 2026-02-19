<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') | Indian Creek Camp</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- TipTap Editor -->
    @vite(['resources/js/admin/tiptap.js'])
    
    <style>
        /* 60/30/10 Color Rule - Warm Autumn Professional */
        :root {
            /* 60% - Dominant: Warm Off-White/Cream */
            --color-bg-primary: #FAF8F5;
            --color-bg-secondary: #F5F1EB;
            --color-text-primary: #2C2416;
            --color-text-secondary: #5C4D3C;
            
            /* 30% - Secondary: Warm Beige/Taupe */
            --color-sidebar: #E8E2D9;
            --color-card: #FFFFFF;
            --color-border: #D4C8B8;
            --color-hover: #DDD5C9;
            
            /* 10% - Accent: Burnt Orange/Terracotta */
            --color-accent: #B85C38;
            --color-accent-hover: #9A4A2B;
            --color-accent-light: #F5E6DF;
        }
        
        body {
            background-color: var(--color-bg-primary);
            color: var(--color-text-primary);
        }
        
        .admin-sidebar {
            background-color: var(--color-sidebar);
            border-right: 1px solid var(--color-border);
        }
        
        .admin-navbar {
            background-color: var(--color-card);
            border-bottom: 1px solid var(--color-border);
        }
        
        .admin-card {
            background-color: var(--color-card);
            border: 1px solid var(--color-border);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .admin-btn-primary {
            background-color: var(--color-accent);
            border-color: var(--color-accent);
            color: white;
        }
        
        .admin-btn-primary:hover {
            background-color: var(--color-accent-hover);
            border-color: var(--color-accent-hover);
        }
        
        .admin-btn-ghost {
            background-color: transparent;
            border-color: transparent;
            color: var(--color-text-secondary);
        }
        
        .admin-btn-ghost:hover {
            background-color: var(--color-hover);
        }
        
        .admin-menu-item {
            color: var(--color-text-secondary);
            border-radius: 0.5rem;
            transition: all 0.2s;
        }
        
        .admin-menu-item:hover {
            background-color: var(--color-hover);
            color: var(--color-text-primary);
        }
        
        .admin-menu-item.active {
            background-color: var(--color-accent-light);
            color: var(--color-accent);
            font-weight: 600;
        }
        
        .admin-menu-title {
            color: var(--color-text-secondary);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
            opacity: 0.7;
        }
        
        .admin-link {
            color: var(--color-accent);
        }
        
        .admin-link:hover {
            color: var(--color-accent-hover);
        }
        
        .admin-table-header {
            background-color: var(--color-bg-secondary);
            color: var(--color-text-secondary);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }
        
        .admin-input {
            background-color: var(--color-card);
            border: 1px solid var(--color-border);
            color: var(--color-text-primary);
        }
        
        .admin-input:focus {
            border-color: var(--color-accent);
            outline: 2px solid var(--color-accent-light);
            outline-offset: 0;
        }
        
        .admin-badge {
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .admin-badge-success {
            background-color: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #A5D6A7;
        }
        
        .admin-badge-error {
            background-color: #FFEBEE;
            color: #C62828;
            border: 1px solid #EF9A9A;
        }
        
        .admin-badge-warning {
            background-color: #FFF3E0;
            color: #EF6C00;
            border: 1px solid #FFCC80;
        }
        
        .admin-badge-info {
            background-color: #E3F2FD;
            color: #1565C0;
            border: 1px solid #90CAF9;
        }
        
        .admin-badge-ghost {
            background-color: var(--color-bg-secondary);
            color: var(--color-text-secondary);
            border: 1px solid var(--color-border);
        }
        
        .admin-footer {
            background-color: var(--color-card);
            border-top: 1px solid var(--color-border);
            color: var(--color-text-secondary);
        }
        
        /* Alert styles */
        .admin-alert-success {
            background-color: #E8F5E9;
            border-color: #A5D6A7;
            color: #2E7D32;
        }
        
        .admin-alert-error {
            background-color: #FFEBEE;
            border-color: #EF9A9A;
            color: #C62828;
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen" style="background-color: var(--color-bg-primary);">
    <div class="drawer lg:drawer-open">
        <input id="admin-drawer" type="checkbox" class="drawer-toggle" />
        
        <!-- Main content -->
        <div class="drawer-content flex flex-col min-h-screen" style="background-color: var(--color-bg-primary);">
            <!-- Navbar -->
            <div class="navbar sticky top-0 z-10 admin-navbar" style="height: 64px;">
                <div class="flex-none lg:hidden">
                    <label for="admin-drawer" class="btn btn-square btn-ghost drawer-button">
                        <x-tabler-menu-2 class="w-6 h-6" style="color: var(--color-text-secondary);" />
                    </label>
                </div>
                <div class="flex-1">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost text-xl normal-case" style="color: var(--color-text-primary);">
                        <span class="font-light">Indian Creek Camp</span> <span class="font-semibold">Admin</span>
                    </a>
                </div>
                <div class="flex-none gap-2">
                    <div class="dropdown dropdown-end">
                        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full flex items-center justify-center" style="background-color: var(--color-accent-light); color: var(--color-accent);">
                                <span class="text-lg font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        </label>
                        <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content rounded-box w-52 admin-card">
                            <li><a href="{{ route('admin.users.edit', auth()->id()) }}" style="color: var(--color-text-primary);">Profile</a></li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}" class="inline">
                                    @csrf
                                    <button type="submit" class="w-full text-left" style="color: var(--color-text-primary);">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main class="flex-1 p-6 lg:p-8">
                @include('admin.components.alert')
                
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="footer footer-center p-4 admin-footer mt-auto">
                <div>
                    <p class="text-sm">&copy; {{ date('Y') }} Indian Creek Baptist Camp. All rights reserved.</p>
                </div>
            </footer>
        </div>

        <!-- Sidebar -->
        <div class="drawer-side z-20">
            <label for="admin-drawer" class="drawer-overlay" style="background-color: rgba(0,0,0,0.3);"></label>
            <aside class="w-72 min-h-full admin-sidebar flex flex-col">
                <!-- Logo Area -->
                <div class="p-6 border-b" style="border-color: var(--color-border);">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-2 py-2 rounded-lg transition-all hover:opacity-80" style="color: var(--color-text-primary);">
                        <x-tabler-arrow-left class="w-5 h-5" style="color: var(--color-accent);" />
                        <span class="font-medium">View Website</span>
                    </a>
                </div>
                
                <!-- Navigation -->
                <nav class="flex-1 p-4 overflow-y-auto">
                    <ul class="menu menu-lg gap-1">
                        <li class="admin-menu-title px-4 py-2">Main</li>
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="admin-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <x-tabler-layout-dashboard class="w-5 h-5" />
                                <span>Dashboard</span>
                            </a>
                        </li>
                        
                        <li class="admin-menu-title px-4 py-2 mt-4">Content</li>
                        <li>
                            <a href="{{ route('admin.camp-types.index') }}" class="admin-menu-item {{ request()->routeIs('admin.camp-types.*') ? 'active' : '' }}">
                                <x-tabler-tag class="w-5 h-5" />
                                <span>Camp Types</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.camp-weeks.index') }}" class="admin-menu-item {{ request()->routeIs('admin.camp-weeks.*') ? 'active' : '' }}">
                                <x-tabler-calendar-event class="w-5 h-5" />
                                <span>Camp Weeks</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.speakers.index') }}" class="admin-menu-item {{ request()->routeIs('admin.speakers.*') ? 'active' : '' }}">
                                <x-tabler-microphone class="w-5 h-5" />
                                <span>Speakers</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.events.index') }}" class="admin-menu-item {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                                <x-tabler-calendar class="w-5 h-5" />
                                <span>Events</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pages.index') }}" class="admin-menu-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                                <x-tabler-file-text class="w-5 h-5" />
                                <span>Pages</span>
                            </a>
                        </li>
                        
                        <li class="admin-menu-title px-4 py-2 mt-4">CMS Pages</li>
                        <li>
                            <a href="{{ route('admin.home-page.edit') }}" class="admin-menu-item {{ request()->routeIs('admin.home-page.*') ? 'active' : '' }}">
                                <x-tabler-home class="w-5 h-5" />
                                <span>Home Page</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.camp-page.edit') }}" class="admin-menu-item {{ request()->routeIs('admin.camp-page.*') ? 'active' : '' }}">
                                <x-tabler-tent class="w-5 h-5" />
                                <span>Camp Page</span>
                            </a>
                        </li>
                        
                        <li class="admin-menu-title px-4 py-2 mt-4">Settings</li>
                        <li>
                            <a href="{{ route('admin.users.index') }}" class="admin-menu-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <x-tabler-users class="w-5 h-5" />
                                <span>Users</span>
                            </a>
                        </li>
                    </ul>
                </nav>
                
                <!-- Sidebar Footer -->
                <div class="p-4 border-t" style="border-color: var(--color-border);">
                    <div class="text-xs text-center" style="color: var(--color-text-secondary); opacity: 0.6;">
                        Indian Creek Baptist Camp
                    </div>
                </div>
            </aside>
        </div>
    </div>
</body>
</html>
