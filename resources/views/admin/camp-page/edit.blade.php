@extends('admin.layouts.app')

@section('title', 'Camp Page')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Page Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-semibold" style="color: var(--color-text-primary);">Camp Page</h1>
                <p class="mt-1" style="color: var(--color-text-secondary);">Manage the registration flow and camp information</p>
            </div>
            <button type="submit" form="camp-page-form" class="btn px-6 py-2 rounded-lg font-medium admin-btn-primary">
                <x-tabler-device-floppy class="w-5 h-5 mr-2" />
                Save Changes
            </button>
        </div>

        <form id="camp-page-form" action="{{ route('admin.camp-page.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Hero Section Card -->
            <div class="admin-card rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center gap-3" style="border-color: var(--color-border); background-color: var(--color-bg-secondary);">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-accent-light);">
                        <x-tabler-video class="w-5 h-5" style="color: var(--color-accent);" />
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold" style="color: var(--color-text-primary);">Hero Section</h2>
                        <p class="text-sm" style="color: var(--color-text-secondary);">Video banner and main heading</p>
                    </div>
                </div>
                
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Season Text</label>
                            <input type="text" name="hero_season" value="{{ old('hero_season', $campPage->hero_season) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input" placeholder="e.g., Summer 2026">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Helper Text</label>
                            <input type="text" name="hero_helper_text" value="{{ old('hero_helper_text', $campPage->hero_helper_text) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input" placeholder="e.g., Start your adventure in 5 easy steps">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Main Title</label>
                            <input type="text" name="hero_title" value="{{ old('hero_title', $campPage->hero_title) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input" placeholder="e.g., Summer Camp">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Subtitle</label>
                            <input type="text" name="hero_subtitle" value="{{ old('hero_subtitle', $campPage->hero_subtitle) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input" placeholder="e.g., At ICBC">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Background Video (MP4/WebM)</label>
                            <input type="file" name="hero_video" accept="video/mp4,video/webm" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input text-sm">
                            <p class="text-xs mt-1.5" style="color: var(--color-text-secondary);">Upload a short looping video for the hero background</p>
                        </div>
                    </div>
                    
                    @include('admin.components.image-upload', [
                        'name' => 'hero_poster',
                        'label' => 'Video Poster Image',
                        'currentImage' => $campPage->hero_poster,
                    ])
                </div>
            </div>

            <!-- Step 3: Church Registration Card -->
            <div class="admin-card rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center gap-3" style="border-color: var(--color-border); background-color: var(--color-bg-secondary);">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-accent-light);">
                        <x-tabler-building-church class="w-5 h-5" style="color: var(--color-accent);" />
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold" style="color: var(--color-text-primary);">Step 3: Register Your Church</h2>
                        <p class="text-sm" style="color: var(--color-text-secondary);">Church group registration information</p>
                    </div>
                </div>
                
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Section Title</label>
                        <input type="text" name="step_3_title" value="{{ old('step_3_title', $campPage->step_3_title) }}" 
                               class="w-full px-4 py-2.5 rounded-lg admin-input">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Content</label>
                        <textarea name="step_3_content" rows="3" 
                                  class="w-full px-4 py-2.5 rounded-lg admin-input">{{ old('step_3_content', $campPage->step_3_content) }}</textarea>
                    </div>
                    
                    <!-- Step 3 FAQs -->
                    <div class="border-t pt-5" style="border-color: var(--color-border);" x-data="{ faqs: {{ json_encode(old('step_3_faq', $campPage->step_3_faq ?? [])) }} }">
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-medium" style="color: var(--color-text-secondary);">Frequently Asked Questions</label>
                            <button type="button" @click="faqs.push({question: '', answer: ''})" 
                                    class="btn btn-sm px-3 py-1.5 rounded-lg admin-btn-ghost border text-sm" style="border-color: var(--color-border);">
                                <x-tabler-plus class="w-4 h-4 mr-1" />
                                Add FAQ
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            <template x-for="(faq, index) in faqs" :key="index">
                                <div class="p-4 rounded-lg space-y-3" style="background-color: var(--color-bg-secondary);">
                                    <input type="text" :name="`step_3_faq[${index}][question]`" x-model="faq.question" 
                                           class="w-full px-3 py-2 rounded-lg admin-input text-sm" placeholder="Question">
                                    <textarea :name="`step_3_faq[${index}][answer]`" x-model="faq.answer" rows="2" 
                                              class="w-full px-3 py-2 rounded-lg admin-input text-sm" placeholder="Answer"></textarea>
                                    <div class="flex justify-end">
                                        <button type="button" @click="faqs.splice(index, 1)" 
                                                class="btn btn-sm btn-ghost rounded-lg text-sm" style="color: #C62828;">
                                            <x-tabler-trash class="w-4 h-4 mr-1" />
                                            Remove FAQ
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <div x-show="faqs.length === 0" class="text-center py-8 rounded-lg" style="background-color: var(--color-bg-secondary);">
                            <p class="text-sm" style="color: var(--color-text-secondary);">No FAQs added yet</p>
                            <button type="button" @click="faqs.push({question: '', answer: ''})" 
                                    class="mt-2 btn btn-sm px-3 py-1.5 rounded-lg admin-btn-primary text-sm">
                                <x-tabler-plus class="w-4 h-4 mr-1" />
                                Add First FAQ
                            </button>
                        </div>
                    </div>

                    <!-- Step 3 Info Paragraphs -->
                    <div class="border-t pt-5" style="border-color: var(--color-border);" x-data="{ paragraphs: {{ json_encode(old('step_3_info_text', $campPage->step_3_info_text ?? [])) }} }">
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-medium" style="color: var(--color-text-secondary);">Info Box Paragraphs</label>
                            <button type="button" @click="paragraphs.push({paragraph: ''})" 
                                    class="btn btn-sm px-3 py-1.5 rounded-lg admin-btn-ghost border text-sm" style="border-color: var(--color-border);">
                                <x-tabler-plus class="w-4 h-4 mr-1" />
                                Add Paragraph
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            <template x-for="(item, index) in paragraphs" :key="index">
                                <div class="flex gap-3 items-start">
                                    <textarea :name="`step_3_info_text[${index}][paragraph]`" x-model="item.paragraph" rows="2" 
                                              class="flex-1 px-3 py-2 rounded-lg admin-input text-sm" placeholder="Paragraph text"></textarea>
                                    <button type="button" @click="paragraphs.splice(index, 1)" 
                                            class="btn btn-sm btn-ghost btn-square rounded-lg" style="color: #C62828;">
                                        <x-tabler-trash class="w-4 h-4" />
                                    </button>
                                </div>
                            </template>
                        </div>
                        
                        <div x-show="paragraphs.length === 0" class="text-center py-6 rounded-lg" style="background-color: var(--color-bg-secondary);">
                            <button type="button" @click="paragraphs.push({paragraph: ''})" 
                                    class="btn btn-sm px-3 py-1.5 rounded-lg admin-btn-ghost border text-sm" style="border-color: var(--color-border);">
                                <x-tabler-plus class="w-4 h-4 mr-1" />
                                Add Paragraph
                            </button>
                        </div>
                    </div>

                    <div class="border-t pt-5" style="border-color: var(--color-border);">
                        <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Mailing Address</label>
                        <textarea name="step_3_address" rows="3" 
                                  class="w-full px-4 py-2.5 rounded-lg admin-input font-mono text-sm">{{ old('step_3_address', $campPage->step_3_address) }}</textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Registration Form (PDF)</label>
                            <input type="file" name="step_3_download" accept=".pdf" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Download Button Text</label>
                            <input type="text" name="step_3_download_content" value="{{ old('step_3_download_content', $campPage->step_3_download_content) }}" 
                                   class="w-full px-4 py-2.5 rounded-lg admin-input" placeholder="e.g., Download Church Registration">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 4: Camper Registration Card -->
            <div class="admin-card rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center gap-3" style="border-color: var(--color-border); background-color: var(--color-bg-secondary);">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-accent-light);">
                        <x-tabler-users class="w-5 h-5" style="color: var(--color-accent);" />
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold" style="color: var(--color-text-primary);">Step 4: Register Your Campers</h2>
                        <p class="text-sm" style="color: var(--color-text-secondary);">Individual camper registration details</p>
                    </div>
                </div>
                
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Section Title</label>
                        <input type="text" name="step_4_title" value="{{ old('step_4_title', $campPage->step_4_title) }}" 
                               class="w-full px-4 py-2.5 rounded-lg admin-input">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Main Content</label>
                        <textarea name="step_4_content" rows="3" 
                                  class="w-full px-4 py-2.5 rounded-lg admin-input">{{ old('step_4_content', $campPage->step_4_content) }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Info Box Content</label>
                        <textarea name="step_4_info_text" rows="5" 
                                  class="w-full px-4 py-2.5 rounded-lg admin-input">{{ old('step_4_info_text', $campPage->step_4_info_text) }}</textarea>
                    </div>
                    
                    <!-- Step 4 FAQs -->
                    <div class="border-t pt-5" style="border-color: var(--color-border);" x-data="{ faqs: {{ json_encode(old('step_4_faq', $campPage->step_4_faq ?? [])) }} }">
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-medium" style="color: var(--color-text-secondary);">Frequently Asked Questions</label>
                            <button type="button" @click="faqs.push({question: '', answer: ''})" 
                                    class="btn btn-sm px-3 py-1.5 rounded-lg admin-btn-ghost border text-sm" style="border-color: var(--color-border);">
                                <x-tabler-plus class="w-4 h-4 mr-1" />
                                Add FAQ
                            </button>
                        </div>
                        
                        <div class="space-y-3">
                            <template x-for="(faq, index) in faqs" :key="index">
                                <div class="p-4 rounded-lg space-y-3" style="background-color: var(--color-bg-secondary);">
                                    <input type="text" :name="`step_4_faq[${index}][question]`" x-model="faq.question" 
                                           class="w-full px-3 py-2 rounded-lg admin-input text-sm" placeholder="Question">
                                    <textarea :name="`step_4_faq[${index}][answer]`" x-model="faq.answer" rows="2" 
                                              class="w-full px-3 py-2 rounded-lg admin-input text-sm" placeholder="Answer"></textarea>
                                    <div class="flex justify-end">
                                        <button type="button" @click="faqs.splice(index, 1)" 
                                                class="btn btn-sm btn-ghost rounded-lg text-sm" style="color: #C62828;">
                                            <x-tabler-trash class="w-4 h-4 mr-1" />
                                            Remove FAQ
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <div x-show="faqs.length === 0" class="text-center py-8 rounded-lg" style="background-color: var(--color-bg-secondary);">
                            <p class="text-sm" style="color: var(--color-text-secondary);">No FAQs added yet</p>
                            <button type="button" @click="faqs.push({question: '', answer: ''})" 
                                    class="mt-2 btn btn-sm px-3 py-1.5 rounded-lg admin-btn-primary text-sm">
                                <x-tabler-plus class="w-4 h-4 mr-1" />
                                Add First FAQ
                            </button>
                        </div>
                    </div>

                    <div class="border-t pt-5" style="border-color: var(--color-border);">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Camper Registration Form (PDF)</label>
                                <input type="file" name="step_4_download" accept=".pdf" 
                                       class="w-full px-4 py-2.5 rounded-lg admin-input text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Download Button Text</label>
                                <input type="text" name="step_4_download_content" value="{{ old('step_4_download_content', $campPage->step_4_download_content) }}" 
                                       class="w-full px-4 py-2.5 rounded-lg admin-input" placeholder="e.g., Download Camper Registration">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 5: Camp Experience Card -->
            <div class="admin-card rounded-xl overflow-hidden">
                <div class="px-6 py-4 border-b flex items-center gap-3" style="border-color: var(--color-border); background-color: var(--color-bg-secondary);">
                    <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background-color: var(--color-accent-light);">
                        <x-tabler-campfire class="w-5 h-5" style="color: var(--color-accent);" />
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold" style="color: var(--color-text-primary);">Step 5: Come Ready to Enjoy Camp</h2>
                        <p class="text-sm" style="color: var(--color-text-secondary);">What to expect and preparation information</p>
                    </div>
                </div>
                
                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--color-text-secondary);">Section Title</label>
                        <input type="text" name="step_5_title" value="{{ old('step_5_title', $campPage->step_5_title) }}" 
                               class="w-full px-4 py-2.5 rounded-lg admin-input">
                    </div>
                    
                    <!-- Step 5 Content Sections -->
                    <div class="border-t pt-5" style="border-color: var(--color-border);" x-data="{ sections: {{ json_encode(old('step_5_sections', $campPage->step_5_sections ?? [])) }} }">
                        <div class="flex items-center justify-between mb-4">
                            <label class="block text-sm font-medium" style="color: var(--color-text-secondary);">Content Sections</label>
                            <button type="button" @click="sections.push({title: '', content: '', link_url: '', link_text: ''})" 
                                    class="btn btn-sm px-3 py-1.5 rounded-lg admin-btn-ghost border text-sm" style="border-color: var(--color-border);">
                                <x-tabler-plus class="w-4 h-4 mr-1" />
                                Add Section
                            </button>
                        </div>
                        
                        <div class="space-y-4">
                            <template x-for="(section, index) in sections" :key="index">
                                <div class="p-4 rounded-lg space-y-3" style="background-color: var(--color-bg-secondary);">
                                    <input type="text" :name="`step_5_sections[${index}][title]`" x-model="section.title" 
                                           class="w-full px-3 py-2 rounded-lg admin-input text-sm font-medium" placeholder="Section Title">
                                    <textarea :name="`step_5_sections[${index}][content]`" x-model="section.content" rows="3" 
                                              class="w-full px-3 py-2 rounded-lg admin-input text-sm" placeholder="Section Content"></textarea>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <input type="url" :name="`step_5_sections[${index}][link_url]`" x-model="section.link_url" 
                                               class="px-3 py-2 rounded-lg admin-input text-sm" placeholder="Link URL (optional)">
                                        <input type="text" :name="`step_5_sections[${index}][link_text]`" x-model="section.link_text" 
                                               class="px-3 py-2 rounded-lg admin-input text-sm" placeholder="Link Text (optional)">
                                    </div>
                                    <div class="flex justify-end pt-1">
                                        <button type="button" @click="sections.splice(index, 1)" 
                                                class="btn btn-sm btn-ghost rounded-lg text-sm" style="color: #C62828;">
                                            <x-tabler-trash class="w-4 h-4 mr-1" />
                                            Remove Section
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                        
                        <div x-show="sections.length === 0" class="text-center py-8 rounded-lg" style="background-color: var(--color-bg-secondary);">
                            <p class="text-sm" style="color: var(--color-text-secondary);">No content sections added yet</p>
                            <button type="button" @click="sections.push({title: '', content: '', link_url: '', link_text: ''})" 
                                    class="mt-2 btn btn-sm px-3 py-1.5 rounded-lg admin-btn-primary text-sm">
                                <x-tabler-plus class="w-4 h-4 mr-1" />
                                Add First Section
                            </button>
                        </div>
                    </div>

                    <div class="border-t pt-5" style="border-color: var(--color-border);">
                        @include('admin.components.image-upload', [
                            'name' => 'step_5_background_image',
                            'label' => 'Background Image',
                            'currentImage' => $campPage->step_5_background_image,
                        ])
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
