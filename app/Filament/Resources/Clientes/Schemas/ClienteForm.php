<?php

namespace App\Filament\Resources\Clientes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nit_ci')
                    ->default(null),
                TextInput::make('nombre')
                    ->required(),
                TextInput::make('telefono')
                    ->tel()
                    ->default(null),
                TextInput::make('direccion')
                    ->default(null),
                TextInput::make('correo')
                    ->default(null),
            ]);
    }
}
