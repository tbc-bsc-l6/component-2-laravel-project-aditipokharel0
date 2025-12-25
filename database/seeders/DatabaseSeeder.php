use Illuminate\Support\Facades\Hash;

public function run(): void
{
    \App\Models\User::create([
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);

    \App\Models\User::create([
        'name' => 'Teacher One',
        'email' => 'teacher1@example.com',
        'password' => Hash::make('password'),
        'role' => 'teacher',
    ]);

    \App\Models\User::create([
        'name' => 'Teacher Two',
        'email' => 'teacher2@example.com',
        'password' => Hash::make('password'),
        'role' => 'teacher',
    ]);
}
