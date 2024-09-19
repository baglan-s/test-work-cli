<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UserBalanceRemove extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:balance-remove';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove money from user balance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->ask('Enter user ID');

        // Если пользователь не найден, вывести ошибку
        if (!$user = User::find($userId)) {
            $this->error('User not found.');
            
            return;
        }

        $amount = (int)$this->ask('Enter amount to remove');

        // Если пользователь не найден, вывести ошибку
        if ($amount < 0) {
            $this->error('You can remove only positive numbers');
            
            return;
        }

        // Если у пользователя недостаточно средств, вывести ошибку
        if ($user->wallet->balance < $amount) {
            $this->error('Not enough funds.');
            
            return;
        }

        // Уменьшение суммы к балансу
        $user->wallet->balance -= $amount;
        $user->wallet->save();

        // Добавление транзакции
        $user->wallet->transactions()->create([
            'type' => 'expence',
            'amount' => $amount,
        ]);

        $this->info('Money removed successfully.');
        $this->table(
            ['User ID', 'Name', 'Email', 'Balance'],
            [[
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'balance' => $user->wallet->balance,
            ]]
        );
    }
}
