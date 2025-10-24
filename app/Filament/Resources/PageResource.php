<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Pages';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page Information')
                    ->description('Core details about the page.')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Page::class, 'title', ignoreRecord: true)
                                    ->placeholder('e.g., About Us')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (callable $set, $state) {
                                        $set('slug', Str::slug($state));
                                    })
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Page::class, 'slug', ignoreRecord: true)
                                    ->placeholder('e.g., about-us')
                                    ->helperText('Auto-generated from title, but editable.')
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('subtitle')
                                    ->maxLength(255)
                                    ->placeholder('e.g., Learn more about our mission')
                                    ->nullable()
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('location')
                                    ->options([
                                        'about' => 'About',
                                        'camps' => 'Camps',
                                        'resources' => 'Resources',
                                    ])
                                    ->default('about')
                                    ->required()
                                    ->helperText('Where this page appears in the navigation.')
                                    ->columnSpan(1),
                                Forms\Components\Toggle::make('featured')
                                    ->label('Featured Page')
                                    ->helperText('Show a link to this page on the home page.  Only one page should be featured.')
                                    ->default(false)
                                    ->columnSpan(1),
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'active' => 'Active',
                                        'inactive' => 'Inactive',
                                    ])
                                    ->default('active')
                                    ->required()
                                    ->helperText('Control page visibility.')
                                    ->columnSpan(1),
                                Forms\Components\FileUpload::make('image')
                                    ->image()
                                    ->directory('page-images')
                                    ->imageEditor()
                                    ->maxSize(2048)
                                    ->helperText('Optional image (max 2MB) for the page.')
                                    ->nullable()
                                    ->columnSpanFull(),
                                IconPicker::make('icon')
                                    ->label('Icon')
                                    ->helperText('Optional icon for navigation or display.')
                                    ->nullable()
                                    ->columnSpan(1),
                            ]),
                    ]),
                Forms\Components\Section::make('Content')
                    ->description('Rich content for the page.')
                    ->schema([
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('page-attachments')
                            ->maxLength(65535)
                            ->helperText('Main content of the page (supports rich formatting).')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtitle')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->subtitle)
                    ->default('—')
                    ->wrap(),
                Tables\Columns\TextColumn::make('location')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'about' => 'primary',
                        'camps' => 'success',
                        'resources' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),
                Tables\Columns\IconColumn::make('featured')
                    ->label('Featured')
                    ->boolean()
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'active' ? 'success' : 'danger')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->defaultImageUrl('/default-page.jpg')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('icon')
                    ->label('Icon')
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('content')
                    ->html()
                    ->limit(50)
                    ->tooltip(fn ($record) => strip_tags($record->content))
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\SelectFilter::make('location')
                    ->options([
                        'about' => 'About',
                        'camps' => 'Camps',
                        'resources' => 'Resources',
                    ])
                    ->label('Location'),
                Tables\Filters\Filter::make('featured')
                    ->query(fn ($query) => $query->where('featured', true))
                    ->label('Featured Only'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->label('Status'),
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
            ->defaultSort('title', 'asc')
            ->groups([
                Tables\Grouping\Group::make('location')
                    ->label('Location')
                    ->collapsible(true)
                    ->titlePrefixedWithLabel(false)
                    ->getTitleFromRecordUsing(fn ($record) => ucfirst($record->location)),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add relation managers if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
