<?php

use App\Domains\Auth\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->enum('type', [User::TYPE_ADMIN, User::TYPE_USER])->default(User::TYPE_USER);
      $table->string('name')->nullable();
      $table->string('first_name')->nullable();
      $table->string('last_name')->nullable();
      $table->string('email')->unique()->nullable();
      $table->string('phone')->unique()->nullable();
      $table->string('last_otp')->nullable();
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password')->nullable();
      $table->timestamp('password_changed_at')->nullable();
      $table->string('api_token', 80)->unique()->nullable()->default(null);
      $table->unsignedBigInteger('magento_id')->unique()->nullable()->default(null);
      $table->string('magento_token')->unique()->nullable()->default(null);
      $table->string('magento_pwd')->unique()->nullable()->default(null);
      $table->unsignedTinyInteger('active')->default(1);
      $table->string('timezone')->nullable();
      $table->timestamp('last_login_at')->nullable();
      $table->string('last_login_ip')->nullable();
      $table->boolean('to_be_logged_out')->default(false);
      $table->string('provider')->nullable();
      $table->string('provider_id')->nullable();
      $table->rememberToken();
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('users');
  }
}
