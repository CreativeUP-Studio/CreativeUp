<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Seed the clients table.
     */
    public function run(): void
    {
        $clients = [
            [
                'name'      => 'Apex FinTech Solutions',
                'logo'      => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=300',
                'order'     => 1,
                'is_active' => true,
            ],
            [
                'name'      => 'Nova Health Group',
                'logo'      => 'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?auto=format&fit=crop&q=80&w=300',
                'order'     => 2,
                'is_active' => true,
            ],
            [
                'name'      => 'Vanguard Retail',
                'logo'      => 'https://images.unsplash.com/photo-1516876437184-593fda40c7ce?auto=format&fit=crop&q=80&w=300',
                'order'     => 3,
                'is_active' => true,
            ],
            [
                'name'      => 'CyberCloud Systems',
                'logo'      => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=300',
                'order'     => 4,
                'is_active' => true,
            ],
            [
                'name'      => 'Orbital Logistics',
                'logo'      => 'https://images.unsplash.com/photo-1507238691740-187a5b1d37b8?auto=format&fit=crop&q=80&w=300',
                'order'     => 5,
                'is_active' => true,
            ],
            [
                'name'      => 'Lumina Smart Real Estate',
                'logo'      => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=300',
                'order'     => 6,
                'is_active' => true,
            ],
        ];

        foreach ($clients as $client) {
            Client::updateOrCreate(
                ['name' => $client['name']],
                $client
            );
        }
    }
}
