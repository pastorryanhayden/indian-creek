<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\TextInput;
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

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

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
                TextInput::make('main_title')
                ->required(),
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
