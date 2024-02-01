<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Content page')->schema([
                Forms\Components\Grid::make()->schema([
                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->minLength(2)
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (
                            string $operation,
                            string $state,
                            Forms\Set $set,
                        ) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->minLength(2)
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                ]),
                Forms\Components\Textarea::make('description')->rows(3),
                Forms\Components\MarkdownEditor::make('content')->required()->minLength(5),
            ])->collapsible()->columnSpan(2),

            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Grid::make()->schema([
                        Forms\Components\Placeholder::make('created_at')->content(
                            fn (?Page $record): string => $record ? $record->created_at->toFormattedDateString() : '-'
                        ),
                        Forms\Components\Placeholder::make('updated_at')->content(
                            fn (?Page $record): string => $record ? $record->updated_at->diffForHumans() : '-'
                        ),
                    ])
                ])->collapsible()->persistCollapsed(),

                Forms\Components\Section::make('Image')->schema([
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->maxSize(5120)
                        ->disk('public')
                        ->directory('page'),
                    Forms\Components\Toggle::make('show_on_page'),
                ])->collapsible()
            ])->columnSpan(1),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('image')
                    ->toggleable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('title')
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\CheckboxColumn::make('published')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->sortable()
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->sortable()
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
