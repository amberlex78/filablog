<?php

namespace App\Filament\Resources\Blog;

use App\Filament\Resources\Blog\PostResource\Pages;
use App\Models\Blog\Post;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Group::make()->schema([
                Section::make('Post content')->schema([
                    TextInput::make('title')
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
                    Select::make('blog_category_id')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    DatePicker::make('published_at')
                        ->label('Published Date')
                        ->default(now()),
                    MarkdownEditor::make('content')
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
                        fn (?Post $record): string => $record ? $record->created_at->toFormattedDateString() : '-'
                    ),
                    Placeholder::make('updated_at')->content(
                        fn (?Post $record): string => $record ? $record->updated_at->diffForHumans() : '-'
                    ),
                ])->columns()->collapsible()->persistCollapsed(),

                Section::make('Image')->schema([
                    FileUpload::make('image')
                        ->hiddenLabel()
                        ->image()
                        ->maxSize(5120)
                        ->disk('public')
                        ->directory(Post::IMG_BLOG_POST),
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
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('slug')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('enabled')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('published_at')
                    ->label('Published Date')
                    ->tooltip(fn (Post $record): string => $record->published_at?->isPast() ? 'Published' : 'Draft')
                    ->color(fn (Post $record): string => $record->published_at?->isPast() ? 'success' : 'gray')
                    ->sortable()
                    ->date()
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->sortable()
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->sortable()
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                TernaryFilter::make('enabled'),
                SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
