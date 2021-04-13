<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = [
        'Name',
        'ClientId',
        'Type',
        'ContactName',
        'Links',
        'TransferType',
        'CallScript',
        'Description',
        'Status',
        'CreateDate',
        'TransferInstruction',
        'Summary',
        'KeyWords',
        'AssociatedStates',
        'AssociatedActions',
        'IsTransfer',
        'F9Code',
        'CrossPromotion'
    ];
}
