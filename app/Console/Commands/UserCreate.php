<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserCreate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Enter user name');
        $email = $this->ask('Enter user email');
        $password = $this->secret('Enter password');
        $passwordConfirm = $this->secret('Confirm password');

        // Валидация входных данных
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirm,
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
        ]);

        // Если валидация не прошла, вывести ошибки
        if ($validator->fails()) {
            $this->error('Validation failed:');

            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return;
        }

        // Создание пользователя
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Создание кошелька пользователя
        $user->wallet()->create(['balance' => 0]);

        $this->info('User created successfully.');
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
