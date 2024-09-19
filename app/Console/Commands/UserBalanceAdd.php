<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UserBalanceAdd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:balance-add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add money to user balance';

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

        $amount = (int)$this->ask('Enter amount to add');

        // Если пользователь не найден, вывести ошибку
        if ($amount < 0) {
            $this->error('You can add only positive numbers.');
            
            return;
        }

        // Добавление суммы к балансу
        $user->wallet->balance += $amount;
        $user->wallet->save();

        // Добавление транзакции
        $user->wallet->transactions()->create([
            'type' => 'income',
            'amount' => $amount,
        ]);

        $this->info('Money added successfully.');
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
