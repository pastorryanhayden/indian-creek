<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, $state) {
                                $set('slug', Str::slug($state));
                            })
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('description')
                            ->columnSpanFull(),
                        FileUpload::make('image')
                            ->directory('events')
                            ->image()
                            ->maxSize(1024), // 1MB limit
                    ])
                    ->columns(2),

                Section::make('Dates')
                    ->schema([
                        DatePicker::make('start_date')
                            ->required(),
                        DatePicker::make('end_date')
                            ->required()
                            ->afterOrEqual('start_date'),
                    ])
                    ->columns(2),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_open')
                            ->default(true),
                        Toggle::make('is_featured')
                            ->default(false),
                    ])
                    ->columns(2),

                Section::make('Content')
                    ->schema([
                        RichEditor::make('content')
                            ->columnSpanFull(),
                    ]),

                Section::make('Speakers')
                    ->schema([
                        Select::make('speakers')
                            ->multiple()
                            ->relationship('speakers', 'name')
                            ->searchable()
                            ->preload()
                            ->label('Assign Speakers'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->sortable()
                    ->date(),
                TextColumn::make('end_date')
                    ->sortable()
                    ->date(),
                BooleanColumn::make('is_open')
                    ->label('Open'),
                BooleanColumn::make('is_featured')
                    ->label('Featured'),
                TextColumn::make('speakers.count')
                    ->label('Speakers')
                    ->numeric(),
                ImageColumn::make('image')
                    ->size(50),
            ])
           
            ->defaultSort('start_date', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
?>