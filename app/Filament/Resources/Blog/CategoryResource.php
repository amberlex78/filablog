<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\CategoryResource\Pages;
use App\Models\Blog\Category;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Group::make()->schema([
                Section::make('Category content')->schema([
                    TextInput::make('name')
                        ->required()
                        ->minLength(2)
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (
                            ?string $operation,
                            ?string $state,
                            Forms\Set $set,
                        ) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                    TextInput::make('slug')
                        ->required()
                        ->minLength(2)
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    MarkdownEditor::make('description')
                        ->required()
                        ->minLength(10)
                        ->columnSpanFull(),
                    Toggle::make('enabled'),
                ])->columns()->collapsible()->persistCollapsed(),

                Section::make('SEO')->schema([
                    TextInput::make('seo_title')
                        ->minLength(2)
                        ->maxLength(60)
                        ->columnSpanFull(),
                    Textarea::make('seo_description')
                        ->minLength(2)
                        ->maxLength(160)
                        ->rows(2)
                        ->columnSpanFull(),
                ])->columns()->collapsible()->collapsed()->persistCollapsed(),
            ])->columnSpan(['md' => 2, 'lg' => 2]),


            Group::make()->schema([
                Section::make('Dates')->schema([
                    Placeholder::make('created_at')->content(
                        fn (?Category $record): string => $record ? $record->created_at->toFormattedDateString() : '-'
                    ),
                    Placeholder::make('updated_at')->content(
                        fn (?Category $record): string => $record ? $record->updated_at->diffForHumans() : '-'
                    ),
                ])->columns()->collapsible()->persistCollapsed(),

                Section::make('Image')->schema([
                    FileUpload::make('image')
                        ->hiddenLabel()
                        ->image()
                        ->maxSize(5120)
                        ->disk('public')
                        ->directory(Category::IMG_BLOG_CATEGORY),
                    Toggle::make('image_show'),
                ])->collapsible()->persistCollapsed()
            ])->columnSpan(['md' => 2, 'lg' => 1])

        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ImageColumn::make('image'),
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('enabled')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->sortable()
                    ->date()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->sortable()
                    ->date()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
