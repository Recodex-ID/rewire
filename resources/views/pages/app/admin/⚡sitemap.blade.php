<?php

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Sitemap')] class extends Component
{
    /**
     * @return array<int, array{label: string, url: string, type: string, lastModified: \Illuminate\Support\Carbon|null}>
     */
    #[Computed]
    public function entries(): array
    {
        $entries = [
            ['label' => 'Home', 'url' => route('home'), 'type' => 'Page', 'lastModified' => null],
            ['label' => 'Blog index', 'url' => route('blogs'), 'type' => 'Page', 'lastModified' => null],
        ];

        foreach (Post::query()->published()->latest()->get() as $post) {
            $entries[] = [
                'label' => $post->title,
                'url' => route('blog.detail', $post->slug),
                'type' => 'Post',
                'lastModified' => $post->updated_at,
            ];
        }

        return $entries;
    }
}; ?>

<div class="w-full space-y-6">
    <div class="flex items-start justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <flux:heading size="xl">Sitemap</flux:heading>
                <flux:badge color="zinc" size="sm">{{ count($this->entries) }} URLs</flux:badge>
            </div>
            <flux:subheading>Every public URL included in the live sitemap.</flux:subheading>
        </div>

        <flux:button as="a" :href="route('sitemap')" target="_blank" variant="outline" icon="arrow-top-right-on-square">
            View sitemap.xml
        </flux:button>
    </div>

    <flux:card class="w-full">
        <flux:table>
            <flux:table.columns>
                <flux:table.column>URL</flux:table.column>
                <flux:table.column>Type</flux:table.column>
                <flux:table.column>Last modified</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->entries as $entry)
                    <flux:table.row :key="$entry['url']">
                        <flux:table.cell variant="strong">{{ $entry['url'] }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $entry['type'] }}</flux:table.cell>
                        <flux:table.cell class="whitespace-nowrap">{{ $entry['lastModified']?->diffForHumans() ?? '—' }}</flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </flux:card>
</div>
