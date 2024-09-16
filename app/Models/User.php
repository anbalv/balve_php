<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['username', 'email', 'password', 'role', 'temp_password', 'is_temp_password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['is_temp_password' => 'boolean'];

    /**
     * Set the user's password, only hash it if it's not already hashed.
     *
     * @param string $password
     * @return void
     */
    public function setPasswordAttribute($password)
    {
        // Prüfen, ob das Passwort neu gehasht werden muss oder ob es bereits korrekt gehasht ist
        if (!Hash::needsRehash($password) && strlen($password) !== 60) {
            // Optional: Du kannst hier eine Exception werfen oder einen Log-Eintrag erstellen
            throw new \InvalidArgumentException('Das Passwort hat nicht die erwartete Länge oder ist nicht korrekt gehasht.');
        }

        // Wenn eine Neuhashung notwendig ist, hashe das Passwort
        $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
    }

    // Beziehung zu UserTask
    public function userTasks()
    {
        return $this->hasMany(UserTask::class);
    }

    // Beziehung zu UserPrivateTask
    public function userPrivateTasks()
    {
        return $this->hasMany(UserPrivateTask::class);
    }

    // Beziehung zu TaskInstance
    public function taskInstances()
    {
        return $this->hasMany(TaskInstance::class);
    }

    // Beziehung zu Events
    public function events()
    {
        return $this->hasMany(Event::class, 'user_id');
    }

    // Hilfsmethode zur Rollenprüfung
    public function hasRole($role)
    {
        if (is_array($role)) {
            return in_array($this->role, $role);
        }
        return $this->role === $role;
    }
}
