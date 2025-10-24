<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use App\Models\CampPage as CampPageModel;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Halt;

class CampPage extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.camp-page';

    public function mount(): void
    {
        $campPage = CampPageModel::first();
        if (!isset($campPage)) {
            $campPage = new CampPageModel();
            $campPage->save();
        }
        $this->form->fill($campPage->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Hero Section')
                    ->description('Main hero section at the top of the camp page')
                    ->schema([
                        TextInput::make('hero_season')
                            ->label('Season Text')
                            ->helperText('e.g., "Summer 2026"')
                            ->maxLength(255)
                            ->columnSpan(1),
                        TextInput::make('hero_helper_text')
                            ->label('Helper Text')
                            ->helperText('e.g., "Start your adventure in 5 easy steps"')
                            ->maxLength(255)
                            ->columnSpan(2),
                        TextInput::make('hero_title')
                            ->label('Main Title')
                            ->helperText('e.g., "Summer Camp"')
                            ->maxLength(255)
                            ->columnSpan(2),
                        TextInput::make('hero_subtitle')
                            ->label('Subtitle')
                            ->helperText('e.g., "At ICBC"')
                            ->maxLength(255)
                            ->columnSpan(1),
                        FileUpload::make('hero_video')
                            ->label('Background Video')
                            ->disk('public')
                            ->directory('videos')
                            ->visibility('public')
                            ->acceptedFileTypes(['video/mp4', 'video/webm'])
                            ->helperText('Upload a background video (MP4 or WebM)')
                            ->columnSpan(2),
                        FileUpload::make('hero_poster')
                            ->label('Video Poster Image')
                            ->image()
                            ->disk('public')
                            ->directory('images')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Poster image shown before video loads')
                            ->columnSpan(1),
                    ])
                    ->columns(3),

                Section::make('Step 3: Register Your Church')
                    ->schema([
                        TextInput::make('step_3_title')
                            ->label('Title')
                            ->maxLength(255)
                            ->columnSpan('full'),
                        Textarea::make('step_3_content')
                            ->label('Content')
                            ->rows(3)
                            ->columnSpan('full'),
                        Repeater::make('step_3_faq')
                            ->label('FAQs')
                            ->schema([
                                TextInput::make('question')
                                    ->label('Question')
                                    ->required(),
                                Textarea::make('answer')
                                    ->label('Answer')
                                    ->required()
                                    ->rows(3),
                            ])
                            ->defaultItems(0)
                            ->columns(1)
                            ->columnSpan('full'),
                        Repeater::make('step_3_info_text')
                            ->label('Info Box Paragraphs')
                            ->schema([
                                Textarea::make('paragraph')
                                    ->label('Paragraph')
                                    ->required()
                                    ->rows(2),
                            ])
                            ->defaultItems(0)
                            ->columnSpan('full'),
                        Textarea::make('step_3_address')
                            ->label('Mailing Address')
                            ->rows(3)
                            ->columnSpan('full'),
                        FileUpload::make('step_3_download')
                            ->label('Registration Form (PDF)')
                            ->disk('public')
                            ->directory('downloads')
                            ->visibility('public')
                            ->acceptedFileTypes(['application/pdf'])
                            ->helperText('Upload the church registration form PDF')
                            ->columnSpan(2),
                        TextInput::make('step_3_download_content')
                            ->label('Download Button Text')
                            ->maxLength(255)
                            ->columnSpan(1),
                    ])
                    ->columns(3),

                Section::make('Step 4: Register Your Campers')
                    ->schema([
                        TextInput::make('step_4_title')
                            ->label('Title')
                            ->maxLength(255)
                            ->columnSpan('full'),
                        Textarea::make('step_4_content')
                            ->label('Content')
                            ->rows(3)
                            ->columnSpan('full'),
                        Textarea::make('step_4_info_text')
                            ->label('Info Box Text')
                            ->rows(5)
                            ->columnSpan('full'),
                        Repeater::make('step_4_faq')
                            ->label('FAQs')
                            ->schema([
                                TextInput::make('question')
                                    ->label('Question')
                                    ->required(),
                                Textarea::make('answer')
                                    ->label('Answer')
                                    ->required()
                                    ->rows(3),
                            ])
                            ->defaultItems(0)
                            ->columns(1)
                            ->columnSpan('full'),
                        FileUpload::make('step_4_download')
                            ->label('Camper Registration Form (PDF)')
                            ->disk('public')
                            ->directory('downloads')
                            ->visibility('public')
                            ->acceptedFileTypes(['application/pdf'])
                            ->helperText('Upload the camper registration form PDF')
                            ->columnSpan(2),
                        TextInput::make('step_4_download_content')
                            ->label('Download Button Text')
                            ->maxLength(255)
                            ->columnSpan(1),
                    ])
                    ->columns(3),

                Section::make('Step 5: Come Ready to Enjoy Camp')
                    ->schema([
                        TextInput::make('step_5_title')
                            ->label('Title')
                            ->maxLength(255)
                            ->columnSpan('full'),
                        Repeater::make('step_5_sections')
                            ->label('Content Sections')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Section Title')
                                    ->required(),
                                Textarea::make('content')
                                    ->label('Section Content')
                                    ->required()
                                    ->rows(3),
                                TextInput::make('link_url')
                                    ->label('Link URL (optional)')
                                    ->url(),
                                TextInput::make('link_text')
                                    ->label('Link Text (optional)'),
                            ])
                            ->defaultItems(0)
                            ->columns(1)
                            ->columnSpan('full'),
                        FileUpload::make('step_5_background_image')
                            ->label('Background Image')
                            ->image()
                            ->disk('public')
                            ->directory('images')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Upload a background image for Step 5 section')
                            ->columnSpan('full'),
                    ])
                    ->columns(3),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            $campPage = CampPageModel::first();
            $campPage->update($data);

        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
}
