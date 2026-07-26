<?php

use App\Concerns\PasswordValidationRules;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
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
            'role' => ['required', 'string', Rule::in(Role::query()->pluck('name'))],
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $user->forceFill(['email_verified_at' => now()])->save();

        $user->syncRoles([$this->role]);

        Flux::toast(variant: 'success', text: "{$user->name} was created.");

        $this->reset('name', 'email', 'password', 'password_confirmation');
        $this->role = 'member';

        Flux::modal('create-user')->close();
    }

    public function updateRole(int $userId, string $role): void
    {
        if (! Role::query()->where('name', $role)->exists()) {
            Flux::toast(variant: 'danger', text: 'That role does not exist.');

            return;
        }

        $user = User::query()->findOrFail($userId);

        if ($user->is(Auth::user()) && $role !== 'admin') {
            Flux::toast(variant: 'danger', text: 'You cannot remove your own admin role.');

            return;
        }

        $user->syncRoles([$role]);

        Flux::toast(variant: 'success', text: "{$user->name}'s role was updated.");
    }

    public function delete(int $userId): void
    {
        $user = User::query()->findOrFail($userId);

        if ($user->is(Auth::user())) {
            Flux::toast(variant: 'danger', text: 'You cannot delete your own account.');

            return;
        }

        $user->delete();

        Flux::toast(variant: 'success', text: "{$user->name} was deleted.");
    }

    /**
     * @return \Illuminate\Support\Collection<int, string>
     */
    #[Computed]
    public function roles()
    {
        return Role::query()->pluck('name');
    }

    #[Computed]
    public function users()
    {
        return User::query()
            ->when($this->search, fn ($query) => $query
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%"))
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

    <flux:modal name="create-user" class="max-w-md" focusable>
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
                    <flux:select.option value="{{ $role }}">{{ ucfirst($role) }}</flux:select.option>
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

    <flux:input wire:model.live.debounce.300ms="search" placeholder="Search by name or email" icon="magnifying-glass" class="max-w-sm" />

    <flux:card class="w-full">
        <flux:table :paginate="$this->users">
            <flux:table.columns>
                <flux:table.column>Name</flux:table.column>
                <flux:table.column>Email</flux:table.column>
                <flux:table.column>Role</flux:table.column>
                <flux:table.column>Joined</flux:table.column>
                <flux:table.column></flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->users as $user)
                    <flux:table.row :key="$user->id">
                        <flux:table.cell variant="strong">{{ $user->name }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $user->email }}</flux:table.cell>
                        <flux:table.cell class="py-2">
                            <flux:select
                                size="sm"
                                class="w-32"
                                wire:change="updateRole({{ $user->id }}, $event.target.value)"
                            >
                                @foreach ($this->roles as $role)
                                    <flux:select.option value="{{ $role }}" :selected="$user->hasRole($role)">
                                        {{ ucfirst($role) }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $user->created_at->format('M j, Y') }}</flux:table.cell>
                        <flux:table.cell class="py-0">
                            <flux:modal.trigger name="delete-user-{{ $user->id }}">
                                <flux:button type="button" variant="danger" size="sm" icon="trash" :disabled="$user->is(Auth::user())" />
                            </flux:modal.trigger>

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
</div>
