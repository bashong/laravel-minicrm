# laravel-tester
composer install<br>
cp .env.example .env\
php artisan key:generate\

;before running the command below, edit your AppServiceProvider.php file and inside the boot method set a default string length: 
	
  
    use Illuminate\Support\Facades\Schema;

	public function boot()
	{
		Schema::defaultStringLength(191);
	}
	
php artisan migrate --seed\
php artisan storage:link\
