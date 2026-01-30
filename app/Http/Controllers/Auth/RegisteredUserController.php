<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $services = \App\Models\Service::orderBy('name')->get();
        return view('auth.register', compact('services'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:30', 'unique:users,phone'],
            'role' => ['required', 'in:'.User::ROLE_CUSTOMER.','.User::ROLE_WORKER],
            'service_id' => ['required_if:role,worker', 'nullable', 'exists:services,id'],
            'region' => ['required_if:role,worker', 'nullable', 'string', 'max:100'],
            'district' => ['required_if:role,worker', 'nullable', 'string', 'max:100'],
            'ward' => ['required_if:role,worker', 'nullable', 'string', 'max:100'],
            'street' => ['required_if:role,worker', 'nullable', 'string', 'max:100'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        // If the user registered as a worker, create an empty worker profile to be completed later
        if ($user->role === User::ROLE_WORKER) {
            $data = [
                'user_id' => $user->id,
                'service_id' => $request->service_id,
                'region' => $request->region,
                'district' => $request->district,
                'ward' => $request->ward,
                'street' => $request->street,
            ];
            
            if ($request->hasFile('id_document')) {
                $path = $request->file('id_document')->store('documents', 'public');
                $data['id_document'] = $path;
            }

            if ($request->hasFile('police_clearance')) {
                $path = $request->file('police_clearance')->store('documents', 'public');
                $data['police_clearance'] = $path;
            }

            \App\Models\WorkerProfile::create($data);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
