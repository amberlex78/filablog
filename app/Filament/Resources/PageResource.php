<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
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
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;


class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Group::make()->schema([
                Section::make('Page content')->schema([
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
                    Textarea::make('description')
                        ->rows(3)
                        ->columnSpanFull(),
                    MarkdownEditor::make('content')
                        ->required()
                        ->minLength(10)
                        ->columnSpanFull()
                ])->columns()->collapsible()->persistCollapsed(),
            ])->columnSpan(['md' => 2, 'lg' => 2]),

            Group::make()->schema([
                Section::make('Dates')->schema([
                    Placeholder::make('created_at')->content(
                        fn (?Page $record): string => $record ? $record->created_at->toFormattedDateString() : '-'
                    ),
                    Placeholder::make('updated_at')->content(
                        fn (?Page $record): string => $record ? $record->updated_at->diffForHumans() : '-'
                    ),
                ])->columns()->collapsible()->persistCollapsed(),

                Section::make('Image')->schema([
                    FileUpload::make('image')
                        ->image()
                        ->maxSize(5120)
                        ->disk('public')
                        ->directory('page'),
                    Toggle::make('show_on_page'),
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
                ImageColumn::make('image')
                    ->toggleable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('slug')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                CheckboxColumn::make('published')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->sortable()
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->sortable()
                    ->date()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
