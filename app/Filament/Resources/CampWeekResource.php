<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampWeekResource\Pages;
use App\Models\CampWeek;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CampWeekResource extends Resource
{
    protected static ?string $model = CampWeek::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Camp Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->description('Core details about the camp week.')
                    ->schema([
                        Forms\Components\Grid::make(2) // 2-column grid
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (callable $set, $state) {
                                    $set('slug', Str::slug($state));
                                }),
                            Forms\Components\TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->unique(CampWeek::class, 'slug', ignoreRecord: true)
                                ->columnSpan(1),
                            Forms\Components\Select::make('type_id')
                                ->relationship('type', 'name')
                                ->required()
                                ->preload()
                                ->searchable()
                                ->columnSpan(1),
                            Forms\Components\Select::make('status')
                                ->options([
                                    'active' => 'Active',
                                    'almost full' => 'Almost Full',
                                    'full' => 'Full',
                                    'inactive' => 'Inactive',
                                ])
                                ->default('active')
                                ->required()
                                ->columnSpan(1),
                            
                        ]),
                    ]),
                Forms\Components\Section::make('Schedule')
                    ->description('Set the dates for the camp week.')
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->required()
                            ->native(false)
                            ->displayFormat('Y-m-d')
                            ->columnSpanFull(),
                        Forms\Components\DatePicker::make('end_date')
                            ->required()
                            ->afterOrEqual('start_date')
                            ->native(false)
                            ->displayFormat('Y-m-d')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Additional Details')
                    ->description('Optional notes and speaker assignments.')
                    ->schema([
                        Forms\Components\Textarea::make('notes')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('speakers')
                            ->relationship('speakers', 'name')
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
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type.name')
                    ->label('Type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date(),
                Tables\Columns\TextColumn::make('speakers.name')
                    ->listWithLineBreaks()
                    ->limitList(2)
                    ->expandableLimitedList(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'Teen Camp' => 'Teen Camp',
                        'Kids Camp' => 'Kids Camp',
                        'Family Camp' => 'Family Camp',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ]),
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
            'index' => Pages\ListCampWeeks::route('/'),
            'create' => Pages\CreateCampWeek::route('/create'),
            'edit' => Pages\EditCampWeek::route('/{record}/edit'),
        ];
    }
}
