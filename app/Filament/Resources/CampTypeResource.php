<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampTypeResource\Pages;
use App\Models\CampType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentIconPicker\Forms\IconPicker;

class CampTypeResource extends Resource
{
    protected static ?string $model = CampType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?string $navigationLabel = 'Camp Types';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Camp Type Details')
                    ->description('Define the core information for the camp type.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(CampType::class, 'name', ignoreRecord: true)
                                    ->placeholder('e.g., Teen Camp')
                                    ->helperText('This shows under the type on the main navigation')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('subtitle')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Camp for Teens')
                                    ->columnSpanFull(),
                                Forms\Components\Toggle::make('featured')
                                    ->label('Featured Type')
                                    ->helperText('Mark this type as featured to make it display prominently on the home and camp pages.  Only one type should be featured..')
                                    ->default(false)
                                    ->columnSpan(1),
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->directory('camp-types')
                                    ->imageEditor()
                                    ->maxSize(2048)
                                    ->helperText('Upload an image (max 2MB) to represent this camp type.')
                                    ->columnSpanFull(),
                                IconPicker::make('icon')
                                    ->label('Icon')
                                    ->helperText('Select an icon for the menu.')
                                    ->nullable()
                                    ->columnSpan(1),
                            ]),
                    ]),
                Forms\Components\Section::make('Description')
                    ->description('Provide a brief description of the camp type.')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->required()
                            ->rows(4)
                            ->maxLength(1000)
                            ->placeholder('Describe the camp type...')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->defaultImageUrl('/default-type.jpg'),
                Tables\Columns\IconColumn::make('icon')
                    ->label('Icon')
                    ->alignCenter(),
                Tables\Columns\IconColumn::make('featured')
                    ->label('Featured')
                    ->boolean()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->description)
                    ->wrap(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('M j, Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('featured')
                    ->query(fn (Builder $query) => $query->where('featured', true))
                    ->label('Featured Only'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            // Add relation manager for CampWeeks if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampTypes::route('/'),
            'create' => Pages\CreateCampType::route('/create'),
            'edit' => Pages\EditCampType::route('/{record}/edit'),
        ];
    }
}
