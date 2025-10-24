<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use App\Models\HomePage as HomePageModel;
use Filament\Actions\Action;
use Filament\Notifications\Notification;



class HomePage extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.home-page';

    /*
     * This is setting up the form on load with the contents of the HomePage Model.
     * */
    public function mount(): void
    {
        $homepage = HomePageModel::first();
        if (!isset($homepage)) {
            $homepage = new HomePageModel();
            $homepage->fill([
                'main_title' => 'Made for More',
                'main_subtitle' => 'Indian Creek 2025',
                'main_video' => 'https://www.youtube.com/embed/jYEsgNVv23Y?si=qjsEzRyVW7qWDOTV',
                'show_video' => true,
                'show_directions_section' => true,
            ]);
            $homepage->save();
        }
        $this->form->fill($homepage->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Hero Section')
                    ->description('Main hero section at the top of the home page')
                    ->schema([
                        TextInput::make('main_title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('main_subtitle')
                            ->label('Subtitle')
                            ->maxLength(255),
                        TextInput::make('main_video')
                            ->label('YouTube Embed URL')
                            ->url()
                            ->maxLength(255),
                        Toggle::make('show_video')
                            ->label('Show Video')
                            ->default(true),
                        TextInput::make('hero_button_text')
                            ->label('Button Text')
                            ->maxLength(255),
                        TextInput::make('hero_button_url')
                            ->label('Button URL')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Map Section')
                    ->description('Location and directions section')
                    ->schema([
                        Toggle::make('show_directions_section')
                            ->label('Show Map Section')
                            ->default(true),
                        TextInput::make('map_title')
                            ->label('Title')
                            ->maxLength(255),
                        TextInput::make('map_highlight')
                            ->label('Highlighted Text')
                            ->helperText('Text that appears highlighted in the title')
                            ->maxLength(255),
                        Textarea::make('map_description')
                            ->label('Description')
                            ->rows(3),
                        FileUpload::make('map_image')
                            ->label('Map Image')
                            ->image()
                            ->disk('public')
                            ->directory('images')
                            ->visibility('public')
                            ->imageEditor()
                            ->helperText('Upload a map image'),
                        TextInput::make('map_link')
                            ->label('Map Link URL')
                            ->url()
                            ->maxLength(255),
                        Repeater::make('map_distances')
                            ->label('City Distances')
                            ->schema([
                                TextInput::make('city')
                                    ->label('City Name')
                                    ->required(),
                                TextInput::make('distance')
                                    ->label('Distance')
                                    ->required()
                                    ->helperText('e.g., "2 hours"'),
                            ])
                            ->columns(2)
                            ->defaultItems(0),
                    ])
                    ->columns(2),
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

            $homepage = HomePageModel::first();
            $homepage->update($data);

        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }

}
