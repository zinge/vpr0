<?php

use Illuminate\Database\Seeder;

class DefaultUser extends Seeder
{
  /**
  * Run the database seeds.
  *
  * @return void
  */
  public function run()
  {
    //
    DB::table('users')->insert([
      'name' => 'zinge',
      'email' => 'zinge@localhost',
      'password' => bcrypt('P@ssw0rd')
    ]);
  }
}
