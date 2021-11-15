<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use App\Models\WalletLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WalletController extends Controller
{

    /**
     * Envio de notificação
     * @param $balanceNow saldo atual
     * @param $transfer valor transferido
     * @param $destiny quem recebe
     */
    public function notifySend($balanceNow, $transfer, $destiny)
    {
        $status = 'ok';
        $desc = [];
        $code = 200;
        $serviceExternal = Http::get('http://o4d9z.mocklab.io/notify');
        if($serviceExternal->json()['message'] != 'Success'){
            $status = 'error';
            $desc = [
                    'status' => 'info',
                    'title' => 'Importante!',
                    'msg' => 'Transação realiza, mas notificação não foi enviada!',
                    'balance_now' => $balanceNow
                    ];
            $code = 206;
        }
        return ['status' => $status, 'desc' => $desc, 'code' => $code];
    }

    /**
     * Verifica se é usuário comum e se quem recebe é diferente de quem enviou
     * @param $check status da checagem
     * @param $balance saldo atual
     * @param $destiny quem receberá o dinheiro
     */
    public function checkUser($check, $balance, $destiny)
    {
        # Se usuário não for comum e origin for igual a destino
        if(Auth::user()->type != 'common' or Auth::id() == $destiny){
            $status = 'error';
            $code = 403;
            $desc = [
                    'status' => 'error',
                    'title' => 'Desculpa!',
                    'msg' => 'Operação não permitida.',
                    'balance_now' => round($balance,2)
                    ];
            $check = ['status' => $status, 'desc' => $desc, 'code' => $code];
        }
        return $check;
    }
    
    /**
     * Verifica se existe saldo o sufiente para transfêrencia
     * @param $check status da checagem
     * @param $balance saldo atual
     * @param $transfer valor que será transferido
     */
    public function checkBalance($check, $balance, $transfer)
    {
        # Saldo insuficiente, não realiza a transação
        if($balance < $transfer){
            $status = 'error';
            $code = 400;
            $desc = [
                    'status' => 'error',
                    'title' => 'Desculpa!',
                    'msg' => 'Saldo insuficiente.',
                    'balance_now' => round($balance,2)
                    ];
            $check = ['status' => $status, 'desc' => $desc, 'code' => $code];
        }
        return $check;
    }

    /**
     * Consulta serviço externo para validar / autorizar transação
     * @param $check status da checagem
     * @param $balance saldo atual
     */
    public function checkServiceExternal($check, $balance)
    {
        $serviceExternal = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        if($serviceExternal->json()['message'] != 'Autorizado'){
            $status = 'error';
            $desc = [
                    'status' => 'error',
                    'title' => 'Desculpa!',
                    'msg' => 'Algo errado na validação externa',
                    'balance_now' => round($balance,2)
                    ];
            $code = 400;
            $check = ['status' => $status, 'desc' => $desc, 'code' => $code];
        }
        return $check;
    }

    /**
     * Checa dados do usuário origin
     * Se dados não passar na verificação, não permite transação
     */
    public function validTransaction($balance, $transfer, $destiny)
    {
        $result = ['status' => 'ok', 'desc' => '', 'code' => 200];
        $result = $this->checkUser($result, $balance, $destiny);
        $result = $this->checkBalance($result, $balance, $transfer);
        $result = $this->checkServiceExternal($result, $balance);
        return $result;
    }

    /**
     * Pega dados da carteira de quem está autenticado
     *
     * @param $id ID wallet
     */
    public function getWallet($id = '')
    {
        $where = [['user_id', '=', Auth::id()]]; # Pega wallet por user id
        if($id != ''){
            $where[] = ['id', '=', $id]; # pega wallet pelo próprio id
        }
        return Wallet::where($where)
                ->firstOrFail();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        return view('wallet.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id ID wallet
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('wallet.frm');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $origin dados da carteira origem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $origin)
    {
        $transfer = abs($request->transfer);
        $validTransaction = $this->validTransaction($origin->balance, $transfer, $request->destiny); # Checa dados do usuário
        if($validTransaction['status'] != 'ok'){
            return response()->json($validTransaction['desc'], $validTransaction['code']);
        }
        
        $destiny = Wallet::where('user_id', $request->destiny)->firstOrFail(); # Dados da carteira destino
        $originWalletId = Wallet::transactionStore($origin, $transfer, $destiny); # Efetua transação
        $balanceNow = round(Wallet::find($originWalletId)->balance,2);

        $notify = $this->notifySend($balanceNow, $transfer, $destiny); # Envia notificação
        if($notify['status'] != 'ok'){
            return response()->json($notify['desc'], $notify['code']);
        }

        return response()->json([
            'status' => 'success',
            'title' => 'Muito bom!',
            'msg' => 'Tranferência realizada.',
            'balance_now' => $balanceNow,
        ], 200);
    }

    /**
     * Trás dados de um único registro
     */
    public function dataJson($id = '')
    {
        $datas = $this->getWallet($id);
        $destinations = User::where('active','1')
                ->where('id', '!=',Auth::id())
                ->orderBy('name')
                ->pluck('name','id');
        return response()->json(['data' => $datas, 
                                'destinations' => $destinations,
                                'link_wallet' => route('wallet.index'),
                                'link_edit' => route('wallet.edit', $datas->id),
                                'link_update' => route('wallet.update', $datas->id),
                                'link_api_wallet' => route('wallet_api.datajson'),
                                'link_api_wallet_update' => route('wallet_api.update', $datas->id),
                                'link_api_wallet_transactions' => route('wallet_api.alldatajson')
                                ], 200);
    }

    /**
     * Trás dados de todos os registros
     */
    public function allDataJson()
    {
        $wallet = $this->getWallet();
        $walletLog = WalletLog::where('user_id', Auth::id())->get();
        return response()->json([
                                    'data' => $wallet,
                                    'transactions' => $walletLog,
                                    'link_edit' => route('wallet.edit', $wallet->id),
                                    'link_update' => route('wallet.update', $wallet->id),
                                    'link_api_wallet' => route('wallet_api.datajson'),
                                    'link_api_wallet_update' => route('wallet_api.update', $wallet->id),
                                    'link_api_wallet_transactions' => route('wallet_api.alldatajson')
                                ], 200);
    }
}
