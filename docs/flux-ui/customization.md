# Customization

Knowing how to customize components to your own needs is a crucial part of using Flux. Flux provides multiple levels of customization so that it doesn't have to be all or nothing.

## Tailwind overrides

The first level of customization is simply passing your own Tailwind classes into a component. This often works well for things like custom width:

```blade
<flux:select class="max-w-md">
```

However, there are times where your one-off Tailwind class conflicts with Flux's internal styling. For example, here's how you might attempt to customize the background color of a button:

```blade
<flux:button class="bg-zinc-800 hover:bg-zinc-700">
```

Because Flux applies its own `bg-*` attributes, both classes will be rendered in the output HTML, but only one will be applied:

```html
<button type="button" class="bg-zinc-800 hover:bg-zinc-700 bg-white hover:bg-zinc-100...">
```

The simplest way to resolve these conflicts is using Tailwind's important (`!`) modifier like so:

```blade
<flux:button class="bg-zinc-800! hover:bg-zinc-700!">
```

The conflicting utilities will still both be rendered, however the user-defined ones with the `!` modifier will take precedence.

> **Note:** Sometimes, using `!` is necessary. Most times, you would be better served creating a new component or customizing the existing one with a new variant. More on that below.

## Publishing components

When you first install Flux, all the components are automatically available to be used inside any Blade file in your app.

If you wish, you can "publish" any given component into your project so that you own all the Blade files that make up that component. At first, you might be hesitant to publish components because you won't receive automatic updates, however, this isn't as scary as it may first seem. To publish a component, run the following Artisan command:

```bash
php artisan flux:publish
```

You will be prompted to search and select which components you want to publish. If you want to publish all components at once, you can use the `--all` flag:

```bash
php artisan flux:publish --all
```

Let's say you decided to publish the checkbox component into your project, you would find the component file in the following location:

```
resources/
    views/
        flux/
            checkbox.blade.php
            ...
```

Now, you can continue using the checkbox component like normal, but the published Blade files will be used instead of the original ones. This means you can change anything you like about the component such as classes, slots and variants.

## Global style overrides

Most HTML elements used inside Flux components have a `data-flux-*` attribute. You can use this attribute to override any styles you'd like to. Here's an example of using Tailwind's `@apply` directive to change the default background color of all buttons:

```css
<style>
    [data-flux-button] {
        @apply bg-zinc-800 dark:bg-zinc-400 hover:bg-zinc-700 dark:hover:bg-zinc-300;
    }
</style>
```

