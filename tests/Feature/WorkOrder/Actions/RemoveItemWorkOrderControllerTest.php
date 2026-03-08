<?php

namespace Tests\Feature\WorkOrder\Actions;

use App\OrdemServico;
use App\Pessoa;
use App\ServicoItem;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RemoveItemWorkOrderControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_remove_item_from_work_order_returns_ok(): void
    {
        $user = factory(User::class)->create();
        $person = factory(Pessoa::class)->create();

        $user->pessoa_id = $person->id;
        $user->save();
        $user->refresh();

        // create work order with status that allows modification and not invoiced
        $workOrder = factory(OrdemServico::class)->create([
            'status'      => 'aberto',
            'is_faturado' => 'no',
            'user_id'     => $user->id,
        ]);

        // create item linked to this work order
        $item = factory(ServicoItem::class)->create([
            'ordem_servico_id' => $workOrder->id,
            'active'           => 'yes',
        ]);

        $response = $this
            ->actingAs($user, 'api')
            ->deleteJson(
                route('work-orders.remove-item', ['id' => $item->id])
            );

        $response->assertStatus(200);
    }
}
