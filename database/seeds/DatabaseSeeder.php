<?php
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		DB::table ( 'roles' )->insert ( [ 
				
				[ 
						'name' => 'admin',
						'display_name' => 'Administrateur du site',
						'description' => 'A tous les droits' 
				],
				[ 
						'name' => 'user',
						'display_name' => 'Utilisateur du site',
						'description' => 'Peut demander � r�server la salle' 
				],
				[ 
						'name' => 'prez',
						'display_name' => 'Pr�sident d\'une assos/club',
						'description' => 'Peut demander � r�server la salle' 
				] 
		] );
	}
}
