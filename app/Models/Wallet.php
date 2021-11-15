<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Wallet extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wallet';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'balance',
        'user_id'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))->format('d/m/Y h:i:s');
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))->format('d/m/Y h:i:s');
    }

    /**
     * Grava transação
     * @param $origin dados da carteira de origem
     * @param $transfer valor transferido
     * @param $destiny dados da carteira de destino
     */
    public static function transactionStore($origin, $transfer, $destiny)
    {
        DB::transaction(function () use ($origin, $transfer, $destiny) {
            $originNewBalance = $origin->balance - $transfer;
            $destinyNewBalance = $destiny->balance + $transfer;
            self::originUpdate($origin, $originNewBalance, $transfer);
            self::destinyUpdate($destiny, $destinyNewBalance, $transfer);
            self::transactionLogStore($origin, $originNewBalance, $transfer, $destiny, $destinyNewBalance);
        });
        return $origin->id;
    }

    /**
     * Atualiza a carteira de quem enviou o dinheiro
     * @param $origin dados da carteira origem
     * @param $originNewBalance novo saldo carteira origem
     * @param $transfer valor enviado
     */
    private static function originUpdate($origin, $originNewBalance, $transfer)
    {
        DB::table('wallet')
            ->where('user_id',$origin->user_id)
            ->update(['balance' => $originNewBalance]);
    }

    /**
     * Atualiza a carteira de quem recebeu o dinheiro
     * @param $destiny dados da carteira destino
     * @param $destinyNewBalance novo saldo carteira destino
     * @param $transfer valor recebido
     */
    private static function destinyUpdate($destiny, $destinyNewBalance, $transfer)
    {
        DB::table('wallet')
            ->where('user_id',$destiny->user_id)
            ->update(['balance' => $destinyNewBalance]);
    }

    /**
     * Cria um log da transação = detalhamento
     * @param $origin dados carteira origem
     * @param $originNewBalance novo saldo carteira origem
     * @param $transfer valor enviado
     * @param $destiny dados carteira destino
     * @param $destinyNewBalance novo saldo carteira destino
     */
    private static function transactionLogStore($origin, $originNewBalance, $transfer, $destiny, $destinyNewBalance)
    {
        DB::table('wallet_log')->insert([
            [
                'transaction' => 'send', 
                'before_value' => $origin->balance, # Valor antes da transferência
                'current_value' => $originNewBalance, # Valor após a transferência
                'transfer_value' => $transfer, # Valor que foi transferido
                'user_id_transfer' => $destiny->user_id, # Para quem tranferiu
                'user_id' => $origin->user_id, # Quem enviou o dinheiro
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ],
            [
                'transaction' => 'received', 
                'before_value' => $destiny->balance, # Valor antes do recebimento
                'current_value' => $destinyNewBalance, # Valor após recebimento
                'transfer_value' => $transfer, # Valor que foi transferido
                'user_id_transfer' => $origin->user_id, # Quem transferiu
                'user_id' => $destiny->user_id, # Quem recebeu
                'created_at' => date('Y-m-d h:i:s'),
                'updated_at' => date('Y-m-d h:i:s')
            ]
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
