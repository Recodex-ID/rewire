# Principles

Flux is not a set of UI Blade components, it's a **system** of them. The design of this system is guided by a set of principles that, when applied, result in a cleaner, more creative, and more intuitive app-building experience.

---

## Simplicity

Above all else, simplicity is the quality Flux aims for in its syntax, implementation, and visuals.

Take for example, a basic input field written with Flux:

```blade
<flux:input wire:model="email" label="Email" />
```

It's simple.

Now, consider a dystopian version of the same input field where simplicity is not valued as highly:

```blade
<flux:form.field>
    <flux:form.field.label>Email</flux:form.field.label>
    <div>
        <flux:form.field.text-input wire:model="email" />
    </div>
    @error('email')
        <p class="mt-2 text-red-500 dark:text-red-400 text-xs">{{ $message }}</p>
    @enderror
</flux:form.field>
```

It's a mess.

---

## Complexity

Of course simplicity comes with trade‑offs. It's harder to customize smaller parts of a single component that "does too much".  
That's why Flux offers composable alternatives to overly simple components.

Consider the previous version of the input field:

```blade
<flux:input wire:model="email" label="Email" />
```

If you want more control, you can compose the form field manually from its individual parts:

```blade
<flux:field>
    <flux:label>Email</flux:label>
    <flux:input wire:model="email" />
    <flux:error name="email" />
</flux:field>
```

This gives you the best of both worlds: a short, succinct syntax for the common case, and the ability to customize each part on an as‑needed basis.

---

## Friendliness

When given the chance, Flux chooses familiar, friendly names for its components instead of overly technical ones.

For example, you won't find words like "form controls" in Flux. Most developers use simple terminology like "form inputs" instead.  
Another example is "accordion" instead of "disclosure" for collapsible sections. "disclosure" is the more accurate UI pattern, however, "accordion" is the more commonly used term amongst application developers.

---

## Composition

After simplicity, composability is the next highest value. Ideally, you learn a handful of core components, and then you mix and match them to create (or compose) more robust components.

For example, the following is a common Button component in Flux:

```blade
<flux:button>Options</flux:button>
```

If you want to trigger a dropdown using that button, simply wrap it in `<flux:dropdown>`:

```blade
<flux:dropdown>
    <flux:button>Options</flux:button>
    <flux:navmenu>
        <!-- ... -->
    </flux:navmenu>
</flux:dropdown>
```

Many other libraries force you into more rigid component shapes, disallowing use of a simple button inside a dropdown and instead forcing you to use a more prescriptive alternative like `<flux:dropdown.button>`.

Because composition is a priority, you can turn this navigation dropdown into a "system menu" containing submenus, checkable items, and keyboard control by swapping `navmenu` for `menu`:

```blade
<flux:dropdown>
    <flux:button>Options</flux:button>
    <flux:menu>
        <!-- ... -->
    </flux:menu>
</flux:dropdown>
```

Because `<flux:menu>` is a standalone component in its own right, you can use it to create a context menu that opens on right click instead using the `<flux:context>` component:

```blade
<flux:context>
    <flux:button>Options</flux:button>
    <flux:menu>
        <!-- ... -->
    </flux:menu>
</flux:context>
```

This is the power of composition; the ability to combine independent components into new and more powerful ones.

---

## Consistency

Inconsistent naming, component structure, etc. leads to confusion and frustration. It robs from the intuitiveness of a system.  
Therefore, you will find repeated syntax patterns all over Flux.

One simple example is the use of the word **"heading"** instead of "title" or "name" in many components.  
This way, you can more easily memorize component terms without having to guess or look them up.

Here are a few examples of Flux components that use the word "heading":

```blade
<flux:heading>...</flux:heading>
<flux:menu.submenu heading="...">
<flux:accordion.heading>...</flux:accordion.heading>
```

---

## Brevity

Next to simplicity, brevity is another priority. Flux aims to be as brief as possible without sacrificing any of the above principles.

In general, we avoid compound words that require hyphens in Flux syntax. We also avoid too many levels of nested (dot‑separated) names.

For example, we use the simple word `input` instead of `text-input`, `input-text`, `form-input`, or `form-control`:

```blade
<flux:input>
```

Composition helps with this quest for brevity. Consider the following dropdown menu component:

```blade
<flux:dropdown>
    <flux:button>Options</flux:button>
    <flux:menu>
        <!-- ... -->
    </flux:menu>
</flux:dropdown>
```

Notice the simple, single‑word names for the dropdown component.  
Consider what it might look like if composability and brevity weren't as high a priority:

```blade
<flux:dropdown-menu>
    <flux:dropdown-menu.button>Options</flux:dropdown-menu.button>
    <flux:dropdown-menu.items>
        <!-- ... -->
    </flux:dropdown-menu.items>
</flux:dropdown-menu>
```

---

## Use the browser

Modern browsers have a lot to offer. Flux aims to leverage this to its full potential.  
When you use native browser features, you are depending on reliable behavior that you don't have to download any JavaScript libraries for.

For example, anytime you see a dropdown (popover) in Flux, it will likely be using the `popover` attribute under the hood. This is a relatively new, but widely supported, feature that solves many problems that plague hand‑built dropdown menus:

```html
<div popover>
    <!-- ... -->
</div>
```

> Read more about the [popover attribute](https://developer.mozilla.org/en-US/docs/Web/API/Popover_API).

Another example is using the `<dialog>` element for modals instead of something hand‑written:

```html
<dialog>
    <!-- ... -->
</dialog>
```

By using the native `<dialog>` element, you get a much more consistent and reliable modal experience with things like focus management, accessibility, and keyboard navigation out of the box.

> Read more about the [dialog element](https://developer.mozilla.org/en-US/docs/Web/HTML/Element/dialog).

---

## Use CSS

CSS is becoming a more and more powerful tool for authoring composable design systems. With new features like `:has()`, `:not()` and `:where()`, things that historically required JavaScript, can be done with CSS alone.

When you peer into the source of a Flux component, you may notice some complicated Tailwind utilities being used.  
This is a trade‑off in complexity. In Flux, if a component can use CSS to solve a problem, instead of using PHP or JavaScript, that component will use CSS.

For example, consider how the search icon in the `flux:command.input` component changes color when the input field is focused:

```blade
<flux:command.input placeholder="Search..." />
```

When rendered in the browser, the search icon turns darker when the input is focused. This elegant interaction happens without any JavaScript.  
It's accomplished using CSS's `:has()` selector. Here's the actual Tailwind utility used in the component:

```css
[&:has(+input:focus)]:text-zinc-800
```

The above selector will match any element that has a sibling input element with focus, and changes its text color to a darker shade. This is a simple but powerful example of using modern CSS to enhance the user experience without additional JavaScript.

---

## We style, you space

In general, Flux provides styling out of the box, and leaves spacing to you. Another, more practical way to put it is: **We provide padding, you provide margins.**

For example, take a look at the following "Create account" form:

```blade
<form wire:submit="createAccount">
    <div class="mb-6">
        <flux:heading>Create an account</flux:heading>
        <flux:text class="mt-2">We're excited to have you on board.</flux:text>
    </div>
    <flux:input class="mb-6" label="Email" wire:model="email" />
    <div class="mb-6 flex *:w-1/2 gap-4">
        <flux:input label="Password" wire:model="password" />
        <flux:input label="Confirm password" wire:model="password_confirmation" />
    </div>
    <flux:button type="submit" variant="primary">Create account</flux:button>
</form>
```

Notice how Flux handles the styling of individual components, but leaves the spacing and layout to you.

The reason for this pattern is that **spacing is contextual**, and styling is less‑so. Therefore, if we baked spacing into Flux, you would be constantly overriding it, or worse, preserving it and risking your app looking disjointed.

It takes slightly more work to manage spacing and layout yourself, however, the payoff in flexibility is well worth it.
