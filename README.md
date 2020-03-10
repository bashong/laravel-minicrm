# laravel-tester
composer install<br>
cp .env.example .env<br>
php artisan key:generate<br>

;before running the command below, edit your AppServiceProvider.php file and inside the boot method set a default string length: 


vi app/Providers/AppServiceProvider.php
	
  
    use Illuminate\Support\Facades\Schema;

	public function boot()
	{
		Schema::defaultStringLength(191);
	}
	
php artisan migrate --seed<br>
php artisan storage:link<br>


Access your app on your browser!
