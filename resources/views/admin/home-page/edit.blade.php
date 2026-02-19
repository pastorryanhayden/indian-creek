@extends('admin.layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold" style="color: var(--color-text-primary);">Home Page</h1>
                <p class="mt-1" style="color: var(--color-text-secondary);">Manage your website's homepage content and layout</p>
            </div>
            <button type="submit" form="home-page-form" class="btn px-6 py-2 rounded-lg font-medium admin-btn-primary">
                <x-tabler-device-floppy class="w-5 h-5 mr-2" />
                Save Changes
            </button>
        </div>

        <form id="home-page-form" action="{{ route('admin.home-page.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Hero Section Card -->
            <div class="admin-card rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center gap-3" style="border-color: var(--color-border); background-color: var(--color-bg-secondary);">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-accent-light);">
                        <x-tabler-photo class="w-5 h-5" style="color: var(--color-accent);" />
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold" style="color: var(--color-text-primary);">Hero Section</h2>
                        <p class="text-sm" style="color: var(--color-text-secondary);">Main banner and video settings</p>
                    </div>
                </div>
                
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Main Title <span class="text-error">*</span></label>
                            <input type="text" name="main_title" value="{{ old('main_title', $homePage->main_title) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Subtitle</label>
                            <input type="text" name="main_subtitle" value="{{ old('main_subtitle', $homePage->main_subtitle) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">YouTube Video URL</label>
                        <div class="flex gap-2">
                            <input type="url" name="main_video" value="{{ old('main_video', $homePage->main_video) }}" 
                                   class="flex-1 px-4 py-2.5 rounded-lg admin-input" placeholder="https://www.youtube.com/embed/...">
                        </div>
                        <p class="text-xs mt-1.5" style="color: var(--color-text-secondary);">Use the embed URL format from YouTube</p>
                    </div>
                    
                    <div class="flex items-center gap-3 p-4 rounded-lg" style="background-color: var(--color-bg-secondary);">
                        <input type="checkbox" name="show_video" value="1" {{ old('show_video', $homePage->show_video) ? 'checked' : '' }} 
                               class="checkbox" style="border-color: var(--color-border);" id="show_video">
                        <label for="show_video" class="text-sm font-medium cursor-pointer" style="color: var(--color-text-primary);">
                            Display video on homepage
                        </label>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Button Text</label>
                            <input type="text" name="hero_button_text" value="{{ old('hero_button_text', $homePage->hero_button_text) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input" placeholder="e.g., Learn More">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Button URL</label>
                            <input type="text" name="hero_button_url" value="{{ old('hero_button_url', $homePage->hero_button_url) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input" placeholder="/camps">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Map Section Card -->
            <div class="admin-card rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center justify-between" style="border-color: var(--color-border); background-color: var(--color-bg-secondary);">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-accent-light);">
                            <x-tabler-map-pin class="w-5 h-5" style="color: var(--color-accent);" />
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold" style="color: var(--color-text-primary);">Map & Directions</h2>
                            <p class="text-sm" style="color: var(--color-text-secondary);">Location information and travel distances</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <input type="checkbox" name="show_directions_section" value="1" {{ old('show_directions_section', $homePage->show_directions_section) ? 'checked' : '' }} 
                               class="checkbox" style="border-color: var(--color-border);" id="show_map">
                        <label for="show_map" class="text-sm font-medium cursor-pointer" style="color: var(--color-text-primary);">Show Section</label>
                    </div>
                </div>
                
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Section Title</label>
                            <input type="text" name="map_title" value="{{ old('map_title', $homePage->map_title) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Highlighted Text</label>
                            <input type="text" name="map_highlight" value="{{ old('map_highlight', $homePage->map_highlight) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Description</label>
                        <textarea name="map_description" rows="3" 
                                  class="w-full px-4 py-2.5 rounded-lg admin-input">{{ old('map_description', $homePage->map_description) }}</textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Map Link URL</label>
                            <input type="url" name="map_link" value="{{ old('map_link', $homePage->map_link) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input" placeholder="https://maps.google.com/...">
                        </div>
                    </div>
                    
                    <!-- Map Image Upload -->
                    @include('admin.components.image-upload', [
                        'name' => 'map_image',
                        'label' => 'Map Image',
                        'currentImage' => $homePage->map_image,
                    ])

                    <!-- City Distances Repeater -->
                    <div class="border-t pt-5" style="border-color: var(--color-border);" x-data="{ distances: {{ json_encode(old('map_distances', $homePage->map_distances ?? [])) }} }">
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-medium" style="color: var(--color-text-secondary);">City Distances</label>
                            <button type="button" @click="distances.push({city: '', distance: ''})" 
                                    class="btn btn-sm px-3 py-1.5 rounded-lg admin-btn-ghost border text-sm" style="border-color: var(--color-border);">
                                <x-tabler-plus class="w-4 h-4 mr-1" />
                                Add City
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            <template x-for="(item, index) in distances" :key="index">
                                <div class="flex gap-3 items-end p-4 rounded-lg" style="background-color: var(--color-bg-secondary);">
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium mb-1.5" style="color: var(--color-text-secondary);">City Name</label>
                                        <input type="text" :name="`map_distances[${index}][city]`" x-model="item.city" 
                                               class="w-full px-3 py-2 rounded-lg admin-input text-sm" placeholder="e.g., Springfield">
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-xs font-medium mb-1.5" style="color: var(--color-text-secondary);">Distance</label>
                                        <input type="text" :name="`map_distances[${index}][distance]`" x-model="item.distance" 
                                               class="w-full px-3 py-2 rounded-lg admin-input text-sm" placeholder="e.g., 2 hours">
                                    </div>
                                    <button type="button" @click="distances.splice(index, 1)" 
                                            class="btn btn-sm btn-ghost btn-square rounded-lg mb-0.5" style="color: #C62828;">
                                        <x-tabler-trash class="w-4 h-4" />
                                    </button>
                                </div>
                            </template>
                        </div>
                        
                        <div x-show="distances.length === 0" class="text-center py-8 rounded-lg" style="background-color: var(--color-bg-secondary);">
                            <p class="text-sm" style="color: var(--color-text-secondary);">No cities added yet</p>
                            <button type="button" @click="distances.push({city: '', distance: ''})" 
                                    class="mt-2 btn btn-sm px-3 py-1.5 rounded-lg admin-btn-primary text-sm">
                                <x-tabler-plus class="w-4 h-4 mr-1" />
                                Add First City
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Actions -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="btn px-8 py-2.5 rounded-lg font-medium admin-btn-primary">
                    <x-tabler-device-floppy class="w-5 h-5 mr-2" />
                    Save All Changes
                </button>
            </div>
        </form>
    </div>
@endsection
