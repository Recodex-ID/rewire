# Patterns

Every design decision in Flux was carefully and intentionally made. Understanding these intentions will make your experience with Flux more intuitive.

Ideally, after internalizing some of Flux's design philosophy, you will be able to almost guess how to use a component you're unfamiliar with.

---

## Props vs Attributes

Props and attributes are indistinguishable on the surface, however, we've found it helpful to make a distinction between **flux‑provided properties** called "props" and bespoke "attributes" that will be forwarded directly to an underlying HTML element.

For example, the following component uses a prop called `variant` as well as a bespoke `x-on:change.prevent` attribute:

```blade
<flux:button variant="primary" x-on:change.prevent="...">
```

When the component is rendered in the browser, the output HTML might look something like this:

```html
<button type="button" class="bg-zinc-900 ..." x-on:change.prevent="...">
```

As you can see, the `x-on:change.prevent` attribute was forwarded directly to the underlying HTML element, while the `variant` prop was instead internally used to customize which classes were applied to the button.

---

## Class Merging

Most Flux components apply Tailwind classes to their underlying elements, however, you can also pass your own classes into components and they will be automatically merged with the classes applied by Flux.

Here's an example of making a button full width by passing in the `w-full` Tailwind utility class:

```blade
<flux:button class="w-full">
```

Now, when the component is rendered, the output HTML will contain both the `w-full` class and other classes applied by Flux:

```html
<button type="button" class="w-full border border-zinc-200 ...">
```

### Dealing with Class Merging Conflicts

Occasionally, you may run into conflicts when passing in a Tailwind utility that Flux also applies internally.

For example, you may try to customize the background color of a button by passing in the `bg-zinc-800` Tailwind utility class:

```blade
<flux:button class="bg-zinc-800 hover:bg-zinc-700">
```

However, because Flux applies its own `bg-*` attributes, both classes will be rendered in the output HTML:

```html
<button type="button" class="bg-zinc-800 hover:bg-zinc-700 bg-white hover:bg-zinc-100...">
```

Because both classes exist on the element, the one defined last in CSS wins.

Tailwind's important (`!`) modifier is the simplest way to resolve these conflicts:

```blade
<flux:button class="bg-zinc-800! hover:bg-zinc-700!">
```

The conflicting utilities will still both be rendered, however the user‑defined ones with the `!` modifier will take precedence.

> **Note:** Usage of the `!` modifier can cause more problems than it solves. Below are a few alternatives to consider instead:
> - Publishing the component and adding your own variant.
> - Globally customizing the component by styling the data attributes.
> - Writing a new component for your unique case.

---

## Split Attribute Forwarding

In a perfect world, each Flux component would directly render a single HTML element. However, in practice, some components are more complex than that.

For example, the `flux:input` component actually renders **two** HTML elements by default: a wrapping `<div>` and an underlying `<input>` element:

```html
<div class="...">
    <input type="text" class="...">
</div>
```

This presents a problem when passing bespoke Tailwind classes into the component: which element should receive the provided classes?

In these cases Flux will often split up the forwarded attributes into two groups: **styling‑related** ones like `class` and **behavioral** ones like `autofocus`. It will then apply each to whichever element is most appropriate.

For example, consider passing in the following `class` and `autofocus` attributes:

```blade
<flux:input class="w-full" autofocus>
```

Flux will apply the `w-full` class to the wrapping `<div>` element and the `autofocus` attribute to the underlying `<input>` element:

```html
<div class="w-full ...">
    <input type="text" class="..." autofocus>
</div>
```

---

## Common Props

Now that you've seen some of the nuances of attributes, let's look at some common prop patterns you will encounter as you use Flux.

### Variant

First up is **"variant"**. Any component that offers an alternate visual style uses the `variant` prop to do so.

Here's a list of a few common component variants:

```blade
<flux:button variant="primary" />
<flux:input variant="filled" />
<flux:modal variant="flyout" />
<flux:badge variant="solid" />
<flux:select variant="combobox" />
<flux:separator variant="subtle" />
<flux:tabs variant="segmented" />
```

If you find the need for a variant we don't offer, don't be afraid to publish a component and add your own.

### Icon

Rather than manually adding, styling, and spacing icons inside component slots, you can simply pass the `icon` prop to any component that supports it.

Flux uses [Heroicons](https://heroicons.com) for its icon collection. Heroicons is a set of beautiful and functional icons crafted by the fine folks at Tailwind Labs.

Here's a handful of components you can pass icons into:

```blade
<flux:button icon="magnifying-glass" />
<flux:input icon="magnifying-glass" />
<flux:tab icon="cog-6-tooth" />
<flux:badge icon="user" />
<flux:breadcrumbs.item icon="home" />
<flux:navlist.item icon="user" />
<flux:navbar.item icon="user" />
<flux:menu.item icon="plus" />
```

Occasionally, if a component supports adding an icon to the **end** of an element instead of the beginning by default, you can pass the `icon:trailing` prop as well:

```blade
<flux:button icon:trailing="chevron-down" />
<flux:input icon:trailing="credit-card" />
<flux:badge icon:trailing="x-mark" />
<flux:navbar.item icon:trailing="chevron-down" />
```

### Size

Some components offer size variations through the `size` prop.

Here are a few components that can be sized‑down:

```blade
<flux:button size="sm" />
<flux:select size="sm" />
<flux:input size="sm" />
<flux:tabs size="sm" />
```

Here are a few that can be sized up for larger visual contexts:

```blade
<flux:heading size="lg" />
<flux:badge size="lg" />
```

### Keyboard Hints

Similar to the `icon` prop, many components allow you to add decorative hints for keyboard shortcuts using the `kbd` prop:

```blade
<flux:button kbd="⌘S" />
<flux:tooltip kbd="D" />
<flux:input kbd="⌘K" />
<flux:menu.item kbd="⌘E" />
<flux:command.item kbd="⌘N" />
```

### Inset

Certain components offer the `inset` prop which makes it easy to add the exact amount of negative margin needed to "inset" an element on any axis you specify. This is extremely useful for putting a button or a badge inline with other text and not stretching the entire height of the container.

```blade
<flux:badge inset="top bottom">
<flux:button variant="ghost" inset="left">
```

---

## Prop Forwarding

Occasionally, one component will wrap another and expose it as a simple prop.

For example, here is the Button component that allows you to set the icon using the simple `icon` prop instead of passing an entire Icon component into the Button as a child:

```blade
<flux:button icon="bell" />
```

This is often a more desirable alternative to composing the entire component like so:

```blade
<flux:button>
   <flux:icon.bell />
</flux:button>
```

However, when using the `icon` prop, you are unable to add additional props to the Icon component like `variant`. In these cases, Flux will often expose nested props via prefixes like so:

```blade
<flux:button icon="bell" icon:variant="solid" />
```

---

## Opt‑Out Props

Sometimes Flux will turn a prop "on" by default, or manage its state internally. For example, the `current` prop on the `navbar.item` component. However, you may want to enforce that its value remains `false` for a specific instance of the component.

In these cases, you can use Laravel's dynamic prop syntax (`:`) and pass in `false`:

```blade
<flux:navbar.item :current="false">
```

---

## Shorthand Props

Sometimes a component arrangement is both common and verbose enough that it warrants a shorthand syntax.

For example, here's a full input field:

```blade
<flux:field>
    <flux:label>Email</flux:label>
    <flux:input wire:model="email" type="email" />
    <flux:error name="email" />
</flux:field>
```

This can be shortened to the following:

```blade
<flux:input type="email" wire:model="email" label="Email" />
```

Internally, Flux will expand the above into the full assembly of `field`, `label`, `input`, and `error` components. This way you can keep syntax short and concise, but still have the ability to fully customize things if you'd like to use the full long‑form syntax.

You'll also encounter this pattern with tooltips and buttons. Here's a long‑form tooltip:

```blade
<flux:tooltip content="Settings">
    <flux:button icon="cog-6-tooth" />
</flux:tooltip>
```

Because the above is often repetitive, you can shorten it to a simple `tooltip` prop:

```blade
<flux:button icon="cog-6-tooth" tooltip="Settings" />
```

---

## Data Binding

In Livewire you are used to adding `wire:model` directly to input elements inside your forms. In Flux, the experience is no different. Here are some common components you will often be adding `wire:model` to:

```blade
<flux:input wire:model="email" />
<flux:checkbox wire:model="terms" />
<flux:switch wire:model.live="enabled" />
<flux:textarea wire:model="content" />
<flux:select wire:model="state" />
```

In addition to these common ones you'd expect, here are a few other components you can control via `wire:model`:

```blade
<flux:checkbox.group wire:model="notifications">
<flux:radio.group wire:model="payment">
<flux:tabs wire:model="activeTab">
```

Of course, you can also pass `x-model` or `x-on:change` to any of these and they should behave exactly like native input elements.

---

## Component Groups

When a Flux component can be "grouped", but is otherwise a stand‑alone component, its wrapper component has a `.group` suffix.

All of the following components can be used on their own, or grouped together:

```blade
<flux:button.group>
    <flux:button />
</flux:button.group>
<flux:input.group>
    <flux:input />
</flux:input.group>
<flux:checkbox.group>
    <flux:checkbox />
</flux:checkbox.group>
<flux:radio.group>
    <flux:radio />
</flux:radio.group>
```

Alternatively, if a component **cannot** be used on its own, but can be grouped, the wrapper will often be the main name of the component, and each child will have a `.item` suffix:

```blade
<flux:accordion>
    <flux:accordion.item />
</flux:accordion>
<flux:menu>
    <flux:menu.item />
</flux:menu>
<flux:breadcrumbs>
    <flux:breadcrumbs.item />
</flux:breadcrumbs>
<flux:navbar>
    <flux:navbar.item />
</flux:navbar>
<flux:navlist>
    <flux:navlist.item />
</flux:navlist>
<flux:navmenu>
    <flux:navmenu.item />
</flux:navmenu>
<flux:command>
    <flux:command.item />
</flux:command>
<flux:autocomplete>
    <flux:autocomplete.item />
</flux:autocomplete>
```

---

## Root Components

Most of the time, when a component can be composed of many sub‑components, you will see compound names like the ones mentioned above. However, for components that are larger or more "primitive" feeling than the others, they will lack a common prefix, and instead use the name of the component itself.

For example, this is Flux's `field` component:

```blade
<flux:field>
    <flux:label></flux:label>
    <flux:description></flux:description>
    <flux:error></flux:error>
</flux:field>
```

You'll notice bare component names like `flux:label`, instead of `flux:field.label`. The reasoning for this is to avoid overly verbose hierarchies in common components that would result in naming like `flux:field.label.badge`.

You will also see this pattern with `<flux:table>`.

---

## Anomalies

As painful as it is, sometimes for something to "feel right", you have to abandon consistency for one reason or another.

For example, the `flux:tabs` component doesn't follow the aforementioned rules:

```blade
<flux:tab.group>
    <flux:tabs>
        <flux:tab>
    </flux:tabs>
    <flux:tab.panel>
</flux:tab.group>
```

---

## Slots

In general, Flux prefers composing multiple components together rather than using slots. However, there are times where there is no substitute and slots are the perfect solution.

To demonstrate, consider the following input component with an `x-mark` icon:

```blade
<flux:input icon:trailing="x-mark" />
```

If you wanted to wrap the icon in a clickable button to perform an action, there is no way to achieve that without slots (or without offering an extremely verbose, custom syntax).

Here is the above, rewritten with a wrapping button:

```blade
<flux:input>
    <x-slot name="iconTrailing">
        <flux:button icon="x-mark" size="sm" variant="subtle" wire:click="clear" />
    </x-slot>
</flux:input>
```

---

## Paper Cuts

Here are a few gotchas that you might encounter while using Flux.

### Blade Components vs HTML Elements

When dealing with plain HTML elements in Blade, you are free to use expressions like `@if` inside opening tags. However, those expressions are **not supported** inside the opening tag of a Blade or Flux component. Instead, you must stay within the confines of the Blade component dynamic attribute syntax:

```blade
<!-- Conditional attributes: -->
<input @if ($disabled) disabled @endif>
<flux:input :disabled="$disabled">
```
