<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login | Indian Creek Camp</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
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
            background: linear-gradient(135deg, var(--color-bg-secondary) 0%, var(--color-bg-primary) 100%);
        }
        
        .login-card {
            background-color: var(--color-card);
            border: 1px solid var(--color-border);
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        
        .login-input {
            background-color: var(--color-card);
            border: 1px solid var(--color-border);
            color: var(--color-text-primary);
        }
        
        .login-input:focus {
            border-color: var(--color-accent);
            outline: none;
            box-shadow: 0 0 0 3px var(--color-accent-light);
        }
        
        .login-btn {
            background-color: var(--color-accent);
            color: white;
        }
        
        .login-btn:hover {
            background-color: var(--color-accent-hover);
        }
        
        .login-link {
            color: var(--color-accent);
        }
        
        .login-link:hover {
            color: var(--color-accent-hover);
        }
    </style>
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo / Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-4" style="background-color: var(--color-accent-light);">
                <x-tabler-tent class="w-8 h-8" style="color: var(--color-accent);" />
            </div>
            <h1 class="text-2xl font-semibold" style="color: var(--color-text-primary);">Indian Creek Camp</h1>
            <p class="mt-1" style="color: var(--color-text-secondary);">Admin Panel</p>
        </div>
        
        <!-- Login Card -->
        <div class="login-card rounded-2xl p-8">
            <h2 class="text-xl font-semibold mb-6 text-center" style="color: var(--color-text-primary);">Sign In</h2>
            
            @if($errors->any())
                <div class="mb-6 p-4 rounded-lg flex items-start gap-3" style="background-color: #FFEBEE; border: 1px solid #EF9A9A; color: #C62828;">
                    <x-tabler-alert-circle class="w-5 h-5 flex-shrink-0 mt-0.5" />
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif
            
            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="w-full px-4 py-3 rounded-lg login-input transition-all" 
                           placeholder="admin@indiancreek.com" required autofocus>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Password</label>
                    <input type="password" name="password" 
                           class="w-full px-4 py-3 rounded-lg login-input transition-all" 
                           placeholder="••••••••" required>
                </div>
                
                <button type="submit" class="w-full py-3 rounded-lg font-semibold login-btn transition-all">
                    Sign In
                </button>
            </form>
            
            <div class="mt-6 pt-6 border-t text-center" style="border-color: var(--color-border);">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-medium login-link transition-colors">
                    <x-tabler-arrow-left class="w-4 h-4" />
                    Back to Website
                </a>
            </div>
        </div>
        
        <!-- Footer -->
        <p class="text-center mt-8 text-sm" style="color: var(--color-text-secondary); opacity: 0.7;">
            &copy; {{ date('Y') }} Indian Creek Baptist Camp
        </p>
    </div>
</body>
</html>
