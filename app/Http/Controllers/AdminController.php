<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TaskInstance;
use App\Models\ArchivedTaskInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Verwende den Konstruktor, um die Middleware anzuwenden
    public function __construct()
    {
        $this->middleware('admin');
    }

    // Show Admin Dashboard
    public function index()
    {
        $users = User::all();
        return view('admin_dashboard', compact('users')); // Debugging entfernt
    }

    // Set temporary password for a user
    public function setTempPassword($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }

        $temp_password = $this->generateTempPassword();
        $user->temp_password = $temp_password;
        $user->password = Hash::make($temp_password);
        $user->is_temp_password = true;

        try {
            $user->save();
            $this->sendTempPasswordEmail($user, $temp_password);
            return response()->json([
                'status' => 'success',
                'message' => 'Temporary password set for ' . $user->username,
                'temp_password' => $temp_password
            ]);
        } catch (\Exception $e) {
            Log::error('Error setting temporary password: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error setting temporary password']);
        }
    }

    // Change user role
    public function changeRole(Request $request)
    {
        $user_id = $request->input('user_id');
        $new_role = $request->input('new_role');

        $user = User::find($user_id);
        if ($user) {
            $user->role = $new_role;
            try {
                $user->save();
                return response()->json(['status' => 'success', 'message' => 'Role successfully changed']);
            } catch (\Exception $e) {
                Log::error('Error changing user role: ' . $e->getMessage());
                return response()->json(['status' => 'error', 'message' => 'Error changing role']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }
    }

    // Archive tasks based on date range
    public function archiveTasks(Request $request)
    {
        if ($request->isMethod('post')) {
            $start_date = Carbon::parse($request->input('start_date'));
            $end_date = Carbon::parse($request->input('end_date'));

            try {
                TaskInstance::whereBetween('date', [$start_date, $end_date])
                    ->chunkById(100, function ($tasks) {
                        foreach ($tasks as $task) {
                            ArchivedTaskInstance::create([
                                'private_task_id' => $task->private_task_id,
                                'user_id' => $task->user_id,
                                'date' => $task->date,
                                'status' => $task->status,
                                'assigned_points' => $task->assigned_points,
                                'earned_points' => $task->earned_points,
                            ]);
                            $task->delete();
                        }
                    });

                return redirect()->back()->with('success', 'Tasks successfully archived');
            } catch (\Exception $e) {
                Log::error('Error archiving tasks: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Error archiving tasks');
            }
        }

        $user_points = ArchivedTaskInstance::select('user_id', DB::raw('count(id) as archived_count'), DB::raw('sum(assigned_points) as total_assigned_points'), DB::raw('sum(earned_points) as total_earned_points'))
            ->groupBy('user_id')
            ->with('user')
            ->get();

        return view('archive_tasks', compact('user_points'));
    }

    // Generate random temporary password
    private function generateTempPassword()
    {
        return bin2hex(random_bytes(6));  // 12 characters long random password
    }

    // Send email with temporary password
    private function sendTempPasswordEmail($user, $temp_password)
    {
        $email_addresses = User::where('role', 'admin')->pluck('email')->toArray();
        if ($user->email) {
            $email_addresses[] = $user->email;
        }

        try {
            Mail::send([], [], function ($message) use ($email_addresses, $user, $temp_password) {
                $message->to($email_addresses)
                    ->subject('Temporary Password Set')
                    ->setBody("Hello " . $user->username . ",\n\nYour temporary password is: " . $temp_password . "\nPlease change it after logging in.");
            });
        } catch (\Exception $e) {
            Log::error('Failed to send email to ' . $user->email . ': ' . $e->getMessage());
        }
    }
}
