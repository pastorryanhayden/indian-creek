<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SpeakerResource\Pages;
use App\Models\Speaker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SpeakerResource extends Resource
{
    protected static ?string $model = Speaker::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';

    protected static ?string $navigationGroup = 'Camp Management';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Personal Information')
                    ->description('Basic details about the speaker.')
                    ->schema([
                        Forms\Components\Grid::make(2) // 2-column grid
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),
                            Forms\Components\FileUpload::make('image')
                                ->image()
                                ->directory('speaker-images')
                                ->required()
                                ->columnSpanFull()
                                ->imageEditor(),
                        ]),
                    ]),
                Forms\Components\Section::make('Biography')
                    ->description('Provide a brief bio for the speaker.')
                    ->schema([
                        Forms\Components\Textarea::make('bio')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Camp Week Assignments')
                    ->description('Assign this speaker to one or more camp weeks.')
                    ->schema([
                        Forms\Components\Select::make('camp_weeks')
                            ->relationship('campWeeks', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('bio')
                    ->limit(50),
                Tables\Columns\TextColumn::make('campWeeks.name')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSpeakers::route('/'),
            'create' => Pages\CreateSpeaker::route('/create'),
            'edit' => Pages\EditSpeaker::route('/{record}/edit'),
        ];
    }
}
