<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		$clients = array(
			array('id' => '2','name' => 'Brittney Pawlikowski','address' => '1329 Graham Trace Ln. League City, Tx 77573','phone' => '(713)397-9939','email' => 'Spann.brittney23@gmail.com','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 21:38:45','updated_at' => '2024-08-19 21:38:45'),
			array('id' => '3','name' => 'Nick Pawlikowski','address' => '1329 Graham Trace Ln. League City, Tx 77573','phone' => '(713)724-1202','email' => 'nick@rodzinaconstruction.com','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 21:40:30','updated_at' => '2024-08-19 21:40:30'),
			array('id' => '4','name' => 'Kassie','address' => '1276 Portefino Ln. League City, TX 77573','phone' => '(281)303-3384','email' => NULL,'notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 21:51:53','updated_at' => '2024-08-19 21:51:53'),
			array('id' => '5','name' => 'Lupe Vasquez','address' => NULL,'phone' => '(832)264-5736','email' => 'archerproservices@gmail.com','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 21:53:35','updated_at' => '2024-08-19 21:53:35'),
			array('id' => '6','name' => 'Alex Porter','address' => '831 Garden Oaks Terr Houston, Tx 77018','phone' => '(832)596-9681','email' => 'alex.prtr@gmail.com','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 21:58:16','updated_at' => '2024-08-19 21:58:16'),
			array('id' => '7','name' => 'Judy Faber','address' => '2512 Longwood Dr. Pearland, Tx 77581','phone' => '(281)840-2137','email' => 'jmfaber1960@yahoo.com','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 22:27:50','updated_at' => '2024-08-19 22:28:05'),
			array('id' => '8','name' => 'Artemio Gonzales','address' => '7204 Boyce st. Houston, Tx 77020','phone' => '(832)633-7527','email' => 'temog2010@hotmail.com','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 22:29:44','updated_at' => '2024-08-19 22:30:48'),
			array('id' => '9','name' => 'Thomas Chiou','address' => '1130 Sherwood Run Houston, Tx 77043','phone' => '(713)305-0856','email' => NULL,'notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 22:35:51','updated_at' => '2024-08-19 22:35:51'),
			array('id' => '10','name' => 'David Fernandez','address' => '1121 Sherwood Run Houston, Tx 77043','phone' => '(713)502-5775','email' => NULL,'notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 22:37:51','updated_at' => '2024-08-19 22:37:51'),
			array('id' => '11','name' => 'Daniel Fernandez','address' => NULL,'phone' => '(713)818-0966','email' => NULL,'notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-08-19 22:39:14','updated_at' => '2024-08-19 22:39:14'),
			array('id' => '12','name' => 'Wayne Richardson','address' => '5310 Pineloch Bayou Dr.','phone' => '(713)865-3609','email' => 'meudiffer@yahoo.com','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-09-16 19:13:56','updated_at' => '2024-09-16 19:13:56'),
			array('id' => '13','name' => 'paco','address' => NULL,'phone' => '(920) 375-0163','email' => NULL,'notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-05 18:45:23','updated_at' => '2024-10-05 18:45:23'),
			array('id' => '14','name' => 'Oscar Rios','address' => NULL,'phone' => '(281)253-5554','email' => NULL,'notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-24 17:10:08','updated_at' => '2024-10-24 17:10:08'),
			array('id' => '15','name' => 'Jose','address' => '339 surratt Dr Houston Tx','phone' => '(832)996-6607','email' => NULL,'notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-25 00:19:44','updated_at' => '2024-10-25 00:19:44'),
			array('id' => '16','name' => 'Jessica Renaudo','address' => '1318 Bowen Drive, League City Texas 77573','phone' => NULL,'email' => 'jessica.renaudo@gmail.com','notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-25 02:44:40','updated_at' => '2024-10-25 02:44:40'),
			array('id' => '17','name' => 'Danny','address' => '1334 Graham Trace Ln. League city, Tx 77573','phone' => '(281)898-0278','email' => NULL,'notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-10-26 22:32:28','updated_at' => '2024-10-26 22:32:28'),
			array('id' => '18','name' => 'Efrain Cisneros','address' => NULL,'phone' => '(832)256-4552','email' => NULL,'notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-11-11 00:50:50','updated_at' => '2024-11-11 00:50:50'),
			array('id' => '19','name' => 'Tino Flores','address' => '11806 Foxburo Dr. Houston, Tx 770065','phone' => '(832)877-6867','email' => NULL,'notes' => NULL,'is_active' => '1','created_by' => '2','updated_by' => '2','created_at' => '2024-11-22 01:57:50','updated_at' => '2024-11-22 01:57:50')
		);

        foreach ($clients as $key => $client) {
			Client::create([
				"id" => $client["id"],
				"name" => $client["name"],
				"address" => $client["address"],
				"phone" => $client["phone"],
				"email" => $client["email"],
				"created_by" => $client["created_by"],
				"updated_by" => $client["updated_by"],
			]);
		}
    }
}
