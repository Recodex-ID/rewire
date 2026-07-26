# Theming

We've meticulously designed Flux to look great out of the box, however, every project has its own identity. You can choose from our hand-picked color schemes or build your own theme by customizing CSS variables.

> **Build your theme with our interactive theme builder →**

---

## Base Color

There are essentially two colors in a Flux project: the **base color** and the **accent color**.

- The **base color** is the color of the majority of your application's content. It's used for things like text, backgrounds, borders, etc.
- The **accent color** is the color of the primary action buttons and other interactive elements in your application.

Flux ships with `"zinc"` as the default base color, but you are free to use any shade of gray you'd like.

Because `zinc` is hard‑coded throughout Flux's source code, you will need to redefine it in your CSS file if you'd like to use a different base color.

Here is an example of redefining `"zinc"` to `"slate"` in your CSS file:

```css
/* resources/css/app.css */

/* Re-assign Flux's gray of choice... */
@theme {
  --color-zinc-50: var(--color-slate-50);
  --color-zinc-100: var(--color-slate-100);
  --color-zinc-200: var(--color-slate-200);
  --color-zinc-300: var(--color-slate-300);
  --color-zinc-400: var(--color-slate-400);
  --color-zinc-500: var(--color-slate-500);
  --color-zinc-600: var(--color-slate-600);
  --color-zinc-700: var(--color-slate-700);
  --color-zinc-800: var(--color-slate-800);
  --color-zinc-900: var(--color-slate-900);
  --color-zinc-950: var(--color-slate-950);
}
```

Now, Flux will use `"slate"` as the base color instead of `"zinc"`, and you can use `"slate"` inside your application utilities like you normally would:

```blade
<flux:text class="text-slate-800 dark:text-white">...</flux:text>
```

---

## Accent Color

Under the hood, Flux uses CSS variables for its accent colors. This means that you can change the accent color to any color you'd like.

We recommend you use the interactive theme builder with pre‑selected colors, however, if you'd like to use a different accent color, you can define the following CSS variables in your own CSS file:

```css
/* resources/css/app.css */

@theme {
    --color-accent: var(--color-red-500);
    --color-accent-content: var(--color-red-600);
    --color-accent-foreground: var(--color-white);
}

@layer theme {
    .dark {
        --color-accent: var(--color-red-500);
        --color-accent-content: var(--color-red-400);
        --color-accent-foreground: var(--color-white);
    }
}
```

You'll notice Flux uses three different hues in both light mode and dark mode for its accent color palette. Here are descriptions of each hue:

| Variable | Description |
|----------|-------------|
| `--color-accent` | The main accent color used as the background for primary buttons. |
| `--color-accent-content` | A (typically) darker hue used for text content because it's more readable. |
| `--color-accent-foreground` | The color of (typically) text content on top of an accent‑colored background. |

Tailwind allows you to use reference CSS variable colors inline like so:

```blade
<button class="bg-[var(--color-accent)] text-[var(--color-accent-foreground)]">
```

However, this is not a very ergonomic syntax. Instead you can use utility classes such as:

```blade
<button class="bg-accent text-accent-foreground">
```

---

## Accent Props

Certain design elements like tabs and links use the accent color by default. If you'd like to opt out of this behavior, and use the base color instead, you can use the `:accent="false"` prop:

### Link

```blade
<flux:link :accent="false">Profile</flux:tab>
```

### Tabs

```blade
<flux:tabs>
    <flux:tab :accent="false">Profile</flux:tab>
    <flux:tab :accent="false">Account</flux:tab>
    <flux:tab :accent="false">Billing</flux:tab>
</flux:tabs>
```

### Navbar

```blade
<flux:navbar>
    <flux:navbar.item :accent="false">Profile</flux:navbar.item>
    <flux:navbar.item :accent="false">Account</flux:navbar.item>
    <flux:navbar.item :accent="false">Billing</flux:navbar.item>
</flux:navbar>
```

### Navlist

```blade
<flux:navlist>
    <flux:navlist.item :accent="false">Profile</flux:navlist.item>
    <flux:navlist.item :accent="false">Account</flux:navlist.item>
    <flux:navlist.item :accent="false">Billing</flux:navlist.item>
</flux:navlist>
```
