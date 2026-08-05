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
                'name'         => 'Apex FinTech Solutions',
                'website_url'  => 'https://apexfintech.example.com',
                'industry'     => 'Fintech & Banca',
                'testimonial'  => 'CreativeUP transformó nuestra plataforma de pagos reduciendo la fricción de usuario en un 40%.',
                'order'        => 1,
                'is_active'    => true,
                'is_featured'  => true,
            ],
            [
                'name'         => 'Nova Health Group',
                'website_url'  => 'https://novahealth.example.com',
                'industry'     => 'Salud & Biotecnología',
                'testimonial'  => 'El rediseño UI/UX de nuestro portal de pacientes elevó nuestra calificación de satisfacción a 4.9 estrellas.',
                'order'        => 2,
                'is_active'    => true,
                'is_featured'  => true,
            ],
            [
                'name'         => 'Vanguard Retail & E-Commerce',
                'website_url'  => 'https://vanguardretail.example.com',
                'industry'     => 'E-Commerce & Moda',
                'testimonial'  => 'Duplicamos las conversiones de venta en el primer trimestre tras el lanzamiento del nuevo e-commerce.',
                'order'        => 3,
                'is_active'    => true,
                'is_featured'  => true,
            ],
            [
                'name'         => 'CyberCloud Systems',
                'website_url'  => 'https://cybercloud.example.com',
                'industry'     => 'Ciberseguridad & Cloud',
                'testimonial'  => 'Arquitectura limpia, rápida y un equipo que supera las expectativas en cada entrega.',
                'order'        => 4,
                'is_active'    => true,
                'is_featured'  => true,
            ],
            [
                'name'         => 'Orbital Logistics',
                'website_url'  => 'https://orbitallogistics.example.com',
                'industry'     => 'Logística & Transporte',
                'testimonial'  => 'Desarrollaron nuestro sistema de rastreo en tiempo real en tiempo récord.',
                'order'        => 5,
                'is_active'    => true,
                'is_featured'  => true,
            ],
            [
                'name'         => 'Lumina Smart Real Estate',
                'website_url'  => 'https://luminarealestate.example.com',
                'industry'     => 'Inmobiliaria & PropTech',
                'testimonial'  => 'La estrategia de branding y la plataforma web posicionaron nuestra marca en el sector de lujo.',
                'order'        => 6,
                'is_active'    => true,
                'is_featured'  => true,
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
