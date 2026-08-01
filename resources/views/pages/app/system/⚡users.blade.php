<?php

use App\Concerns\PasswordValidationRules;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

new #[Title('Users')] class extends Component
{
    use PasswordValidationRules, WithPagination;

    public string $search = '';

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $role = 'member';

    public ?int $editingUserId = null;

    public string $editingRole = 'member';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function createUser(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => $this->passwordRules(),
            'role' => ['required', 'string', Rule::in($this->roles)],
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $user->forceFill(['email_verified_at' => now()])->save();

        $user->syncRoles([$this->role]);

        activity('users')->performedOn($user)->withProperties(['role' => $this->role])->log("{$user->name} was created with the {$this->role} role");

        Flux::toast(variant: 'success', text: "{$user->name} was created.");

        $this->reset('name', 'email', 'password', 'password_confirmation');
        $this->role = 'member';

        Flux::modal('create-user')->close();
    }

    public function edit(int $userId): void
    {
        $user = User::query()->with('roles')->findOrFail($userId);

        $this->editingUserId = $user->id;
        $this->editingRole = $user->roles->first()?->name ?? 'member';

        Flux::modal('edit-user')->show();
    }

    public function updateRole(): void
    {
        $this->validate([
            'editingRole' => ['required', 'string', Rule::in($this->roles)],
        ]);

        $user = User::query()->findOrFail($this->editingUserId);

        if ($user->is(Auth::user()) && $this->editingRole !== 'admin') {
            Flux::toast(variant: 'danger', text: 'You cannot remove your own admin role.');

            return;
        }

        if ($user->hasRole('super-admin') && ! Auth::user()->hasRole('super-admin')) {
            Flux::toast(variant: 'danger', text: "You cannot change a super admin's role.");

            return;
        }

        $user->syncRoles([$this->editingRole]);

        activity('users')->performedOn($user)->withProperties(['role' => $this->editingRole])->log("{$user->name}'s role was changed to {$this->editingRole}");

        Flux::toast(variant: 'success', text: "{$user->name}'s role was updated.");

        Flux::modal('edit-user')->close();
    }

    public function delete(int $userId): void
    {
        $user = User::query()->findOrFail($userId);

        if ($user->is(Auth::user())) {
            Flux::toast(variant: 'danger', text: 'You cannot delete your own account.');

            return;
        }

        activity('users')->performedOn($user)->log("{$user->name} ({$user->email}) was deleted");

        $user->delete();

        Flux::toast(variant: 'success', text: "{$user->name} was deleted.");
    }

    /**
     * @return \Illuminate\Support\Collection<int, string>
     */
    #[Computed]
    public function roles()
    {
        return Role::query()
            ->when(! Auth::user()->hasRole('super-admin'), fn ($query) => $query->where('name', '!=', 'super-admin'))
            ->pluck('name');
    }

    #[Computed]
    public function editingUser(): ?User
    {
        return $this->editingUserId ? User::query()->find($this->editingUserId) : null;
    }

    #[Computed]
    public function users()
    {
        return User::query()
            ->when($this->search, fn ($query) => $query
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%"))
            ->when(! Auth::user()->hasRole('super-admin'), fn ($query) => $query
                ->whereDoesntHave('roles', fn ($query) => $query->where('name', 'super-admin')))
            ->with('roles')
            ->orderBy('name')
            ->paginate(10);
    }
}; ?>

<div class="w-full space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <flux:heading size="xl">Users</flux:heading>
            <flux:subheading>Manage member accounts and their roles.</flux:subheading>
        </div>

        <flux:modal.trigger name="create-user">
            <flux:button variant="primary" icon="plus">Create user</flux:button>
        </flux:modal.trigger>
    </div>

    <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by name or email" icon="magnifying-glass" class="max-w-sm" />

    <flux:card class="w-full">
        <flux:table :paginate="$this->users">
            <flux:table.columns>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Role</flux:table.column>
                <flux:table.column>Joined</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->users as $user)
                    <flux:table.row :key="$user->id">
                        <flux:table.cell variant="strong">{{ $user->name }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $user->email }}</flux:table.cell>
                        <flux:table.cell>
                            <flux:badge size="sm" :color="$user->hasRole('super-admin') ? 'amber' : ($user->hasRole('admin') ? 'indigo' : 'zinc')">
                                {{ Str::headline($user->roles->first()?->name ?? 'member') }}
                            </flux:badge>
                        </flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $user->created_at->translatedFormat('l, j F Y') }}</flux:table.cell>
                        <flux:table.cell class="py-0">
                            <div class="flex items-center gap-1">
                                <flux:button
                                    type="button"
                                    variant="outline"
                                    size="sm"
                                    icon="pencil"
                                    wire:click="edit({{ $user->id }})"
                                    :disabled="$user->hasRole('super-admin') && ! Auth::user()->hasRole('super-admin')"
                                />

                                <flux:modal.trigger name="delete-user-{{ $user->id }}">
                                    <flux:button type="button" variant="danger" size="sm" icon="trash" :disabled="$user->is(Auth::user())" />
                                </flux:modal.trigger>
                            </div>

                            <flux:modal name="delete-user-{{ $user->id }}" class="max-w-md" focusable>
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Delete {{ $user->name }}?</flux:heading>
                                        <flux:subheading>This permanently removes their account. This cannot be undone.</flux:subheading>
                                    </div>

                                    <div class="flex justify-end gap-2">
                                        <flux:modal.close>
                                            <flux:button variant="filled">Cancel</flux:button>
                                        </flux:modal.close>

                                        <flux:button variant="danger" wire:click="delete({{ $user->id }})">
                                            Delete
                                        </flux:button>
                                    </div>
                                </div>
                            </flux:modal>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>

    <flux:modal flyout name="create-user" class="max-w-md" focusable>
        <form wire:submit="createUser" class="space-y-6">
            <div>
                <flux:heading size="lg">Create user</flux:heading>
                <flux:subheading>Add a new account and assign it a role.</flux:subheading>
            </div>

            <flux:input label="Name" wire:model="name" />
            <flux:input type="email" label="Email" wire:model="email" />
            <flux:input type="password" viewable label="Password" wire:model="password" />
            <flux:input type="password" viewable label="Confirm password" wire:model="password_confirmation" />

            <flux:select wire:model="role" label="Role">
                @foreach ($this->roles as $role)
                    <flux:select.option value="{{ $role }}">{{ Str::headline($role) }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="filled">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">Create user</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="edit-user" class="max-w-md" focusable>
        <form wire:submit="updateRole" class="space-y-6">
            <div>
                <flux:heading size="lg">Edit {{ $this->editingUser?->name }}</flux:heading>
                <flux:subheading>Change this account's role.</flux:subheading>
            </div>

            <flux:select wire:model="editingRole" label="Role">
                @foreach ($this->roles as $role)
                    <flux:select.option value="{{ $role }}">{{ Str::headline($role) }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="filled">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
