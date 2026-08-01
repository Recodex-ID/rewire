<?php

use Flux\Flux;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

new #[Title('Access Control')] class extends Component
{
    public string $roleName = '';

    public string $permissionName = '';

    public ?int $editingRoleId = null;

    /** @var array<int, int> */
    public array $editingPermissionIds = [];

    public function createRole(): void
    {
        $this->validate([
            'roleName' => ['required', 'string', 'max:255', 'unique:roles,name'],
        ]);

        Role::create(['name' => $this->roleName]);

        activity('access-control')->log("Role \"{$this->roleName}\" was created");

        Flux::toast(variant: 'success', text: "Role \"{$this->roleName}\" was created.");

        $this->reset('roleName');
        Flux::modal('create-role')->close();
    }

    public function createPermission(): void
    {
        $this->validate([
            'permissionName' => ['required', 'string', 'max:255', 'unique:permissions,name'],
        ]);

        Permission::create(['name' => $this->permissionName]);

        activity('access-control')->log("Permission \"{$this->permissionName}\" was created");

        Flux::toast(variant: 'success', text: "Permission \"{$this->permissionName}\" was created.");

        $this->reset('permissionName');
        Flux::modal('create-permission')->close();
    }

    public function editPermissions(int $roleId): void
    {
        $role = Role::query()->with('permissions')->findOrFail($roleId);

        $this->editingRoleId = $role->id;
        $this->editingPermissionIds = $role->permissions->pluck('id')->all();

        Flux::modal('edit-role-permissions')->show();
    }

    public function updatePermissions(): void
    {
        $role = Role::query()->findOrFail($this->editingRoleId);

        $permissions = Permission::query()->whereKey($this->editingPermissionIds)->get();

        $role->syncPermissions($permissions);

        activity('access-control')->performedOn($role)->log("Permissions for role \"{$role->name}\" were updated");

        Flux::toast(variant: 'success', text: "Permissions for \"{$role->name}\" were updated.");

        Flux::modal('edit-role-permissions')->close();
    }

    public function deleteRole(int $roleId): void
    {
        $role = Role::query()->findOrFail($roleId);

        if (in_array($role->name, ['super-admin', 'admin', 'staff'], true)) {
            Flux::toast(variant: 'danger', text: "The \"{$role->name}\" role cannot be deleted.");

            return;
        }

        activity('access-control')->log("Role \"{$role->name}\" was deleted");

        $role->delete();

        Flux::toast(variant: 'success', text: "Role \"{$role->name}\" was deleted.");
    }

    #[Computed]
    public function editingRole(): ?Role
    {
        return $this->editingRoleId ? Role::query()->find($this->editingRoleId) : null;
    }

    #[Computed]
    public function permissions()
    {
        return Permission::query()->orderBy('name')->get();
    }

    #[Computed]
    public function roles()
    {
        return Role::query()->with('permissions')->orderBy('name')->get();
    }
}; ?>

<div class="w-full space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <flux:heading size="xl">Access Control</flux:heading>
            <flux:subheading>Manage roles and the permissions assigned to them.</flux:subheading>
        </div>

        <div class="flex gap-2">
            <flux:modal.trigger name="create-permission">
                <flux:button variant="outline" icon="plus">New permission</flux:button>
            </flux:modal.trigger>
            <flux:modal.trigger name="create-role">
                <flux:button variant="primary" icon="plus">New role</flux:button>
            </flux:modal.trigger>
        </div>
    </div>

    <flux:card class="w-full">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>Role</flux:table.column>
                <flux:table.column>Permissions</flux:table.column>
                <flux:table.column>Actions</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->roles as $role)
                    <flux:table.row :key="$role->id">
                        <flux:table.cell variant="strong">{{ ucfirst($role->name) }}</flux:table.cell>
                        <flux:table.cell>
                            <div class="flex flex-wrap gap-1">
                                @forelse ($role->permissions as $permission)
                                    <flux:badge size="sm" color="zinc">{{ $permission->name }}</flux:badge>
                                @empty
                                    <span class="text-sm text-zinc-400">No permissions</span>
                                @endforelse
                            </div>
                        </flux:table.cell>
                        <flux:table.cell class="py-0">
                            <div class="flex items-center gap-1">
                                <flux:button type="button" variant="outline" size="sm" icon="pencil" wire:click="editPermissions({{ $role->id }})" />

                                <flux:modal.trigger name="delete-role-{{ $role->id }}">
                                    <flux:button type="button" variant="danger" size="sm" icon="trash" :disabled="in_array($role->name, ['super-admin', 'admin', 'staff'])" />
                                </flux:modal.trigger>
                            </div>

                            <flux:modal name="delete-role-{{ $role->id }}" class="max-w-md" focusable>
                                <div class="space-y-6">
                                    <div>
                                        <flux:heading size="lg">Delete "{{ $role->name }}"?</flux:heading>
                                        <flux:subheading>This permanently removes the role. This cannot be undone.</flux:subheading>
                                    </div>

                                    <div class="flex justify-end gap-2">
                                        <flux:modal.close>
                                            <flux:button variant="filled">Cancel</flux:button>
                                        </flux:modal.close>

                                        <flux:button variant="danger" wire:click="deleteRole({{ $role->id }})">
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

    <flux:modal flyout name="create-role" class="max-w-md" focusable>
        <form wire:submit="createRole" class="space-y-6">
            <div>
                <flux:heading size="lg">New role</flux:heading>
                <flux:subheading>Roles can then be assigned to users and granted permissions.</flux:subheading>
            </div>

            <flux:input label="Role name" wire:model="roleName" />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="filled">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">Create role</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal flyout name="create-permission" class="max-w-md" focusable>
        <form wire:submit="createPermission" class="space-y-6">
            <div>
                <flux:heading size="lg">New permission</flux:heading>
                <flux:subheading>Permissions can then be assigned to roles.</flux:subheading>
            </div>

            <flux:input label="Permission name" wire:model="permissionName" />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="filled">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">Create permission</flux:button>
            </div>
        </form>
    </flux:modal>

    <flux:modal name="edit-role-permissions" class="max-w-md" focusable>
        <form wire:submit="updatePermissions" class="space-y-6">
            <div>
                <flux:heading size="lg">Edit "{{ $this->editingRole?->name }}" permissions</flux:heading>
                <flux:subheading>Choose which permissions this role grants.</flux:subheading>
            </div>

            <div class="max-h-72 space-y-2 overflow-y-auto">
                @forelse ($this->permissions as $permission)
                    <flux:checkbox
                        wire:model="editingPermissionIds"
                        value="{{ $permission->id }}"
                        :label="$permission->name"
                    />
                @empty
                    <flux:text class="text-zinc-400">No permissions have been created yet.</flux:text>
                @endforelse
            </div>

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="filled">Cancel</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
