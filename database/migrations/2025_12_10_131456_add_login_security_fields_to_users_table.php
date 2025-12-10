use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // berapa kali gagal login
            $table->unsignedSmallInteger('failed_logins')
                  ->default(0)
                  ->after('password');

            // status diblokir atau tidak
            $table->boolean('is_blocked')
                  ->default(false)
                  ->after('failed_logins');

            // kapan diblokir
            $table->timestamp('blocked_at')
                  ->nullable()
                  ->after('is_blocked');

            // optional: siapa yang buka blokir / blokir (super admin)
            $table->unsignedBigInteger('blocked_by')
                  ->nullable()
                  ->after('blocked_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'failed_logins',
                'is_blocked',
                'blocked_at',
                'blocked_by',
            ]);
        });
    }
};
