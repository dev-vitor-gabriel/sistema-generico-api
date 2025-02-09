<?php

namespace App\Enums;

enum StatusVendaEnum: string
{
    case Aberta = 0;
    case Negociando = 1;
    case Fechada = 2;
}
