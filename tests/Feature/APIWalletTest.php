<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Wallet;
use Tests\TestCase;

class APIWalletTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Lista carteira do usuário
     * @test
     * @group wallet
     */
    public function a_wallet_can_be_listed()
    {
        $origin = User::factory()->create(); 
        Wallet::create(['balance' => 120, 'user_id' => $origin->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $origin->api_token)
        ->json('get', '/api/wallet/data');
        $response->assertStatus(200);
    }

    /**
     * Lista transações da carteira do usuário
     * @test
     * @group wallet
     */
    public function a_wallet_transactions_can_be_listed()
    {
        $origin = User::factory()->create(); 
        Wallet::create(['balance' => 120, 'user_id' => $origin->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $origin->api_token)
        ->json('get', '/api/wallet/transactions');
        $response->assertStatus(200);
    }

    /**
     * Um usuário comum pode transferir dinheiro
     * @test
     * @group wallet
     */
    public function a_wallet_common_can_send_money()
    {
        $origin = User::factory()->create(); 
        Wallet::create(['balance' => 120, 'user_id' => $origin->id]);

        $destiny = User::factory()->create(); 
        Wallet::create(['balance' => 100, 'user_id' => $destiny->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $origin->api_token)
        ->json('put', '/api/wallet/money/send/'.$origin->id,[
            'transfer' => 10, 'destiny' => $destiny->id
        ]);
        $response->assertStatus(200);
    
    }

    /**
     * Um usuário comum com saldo insuficiente
     * Não pode fazer transferência
     * @test
     * @group wallet
     */
    public function a_wallet_common_can_not_send_money_insufficient_funds()
    {
        $origin = User::factory()->create(); 
        Wallet::create(['balance' => 2, 'user_id' => $origin->id]);

        $destiny = User::factory()->create(); 
        Wallet::create(['balance' => 100, 'user_id' => $destiny->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $origin->api_token)
        ->json('put', '/api/wallet/money/send/'.$origin->id,[
            'transfer' => 20, 'destiny' => $destiny->id
        ]);
        $response->assertStatus(400);
    
    }

    /**
     * Um usuário lojista
     * Não pode fazer transferência
     * @test
     * @group wallet
     */
    public function a_wallet_shopkeeper_can_not_send_money()
    {
        $origin = User::factory()->create(['type' => 'shopkeeper']); 
        Wallet::create(['balance' => 500, 'user_id' => $origin->id]);

        $destiny = User::factory()->create(); 
        Wallet::create(['balance' => 100, 'user_id' => $destiny->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $origin->api_token)
        ->json('put', '/api/wallet/money/send/'.$origin->id,[
            'transfer' => 50, 'destiny' => $destiny->id
        ]);
        $response->assertStatus(403);
    
    }

    /**
     * Um usuário comum
     * Não pode fazer transferência para si mesmo
     * @test
     * @group wallet
     */
    public function a_wallet_can_not_send_money_to_yourself()
    {
        $origin = User::factory()->create(); 
        Wallet::create(['balance' => 100, 'user_id' => $origin->id]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $origin->api_token)
        ->json('put', '/api/wallet/money/send/'.$origin->id,[
            'transfer' => 50, 'destiny' => $origin->id
        ]);
        $response->assertStatus(403);
    
    }
}
