# Modern CSS

## object-fit

image may have different aspect ratio from the available space, this I believe avoids clipping and automatically handles different aspects.

```css
img {
  object-fit: cover;
  object-position: center;
  width: 100%;
  height: 200px;
}
```

## carousel with no javascript

```css
.carousel {
  scroll-snap-type: x mandatory;
  overflow-x: auto;
  display: flex;
  gap: 1rem;
}
.carousel > * { scroll-snap-align: start; }
```

## custom font without flash of invisible text

```css
@font-face {
  font-family: "MyFont";
  src: url("MyFont.woff2");
  font-display: swap;
}
```

## variable fonts in one file

```css
@font-face {
  font-family: "MyVar";
  src: url("MyVar.woff2");
  font-weight: 100 900;
}
```

## grid without numbered columns

in my online cv I have the old pattern with numbered columns, which can be replaced by this

```css
.layout {
  display: grid;
  grid-template-areas: "header header" "sidebar main" "footer footer";
}
.header { grid-area: header; }
.sidebar { grid-area: sidebar; }
```

![Layout](/images/grid-template-areas.jpg)

## accent colour for form controls

```css
input[type="checkbox"],
input[type="radio"] {
  accent-color: #7c3aed;
}
```

## :is() pseudo selector function

```css
.card :is(h1, h2, h3, h4) {
  margin-bottom: 0.5em;
}
ol {
  list-style-type: upper-alpha;
  color: darkblue;
}
:is(ol, ul, menu:unsupported) :is(ol, ul) {
  color: green;
}
:is(ol, ul) :is(ol, ul) ol {
  list-style-type: lower-greek;
  color: chocolate;
}
```

[MDN page](https://developer.mozilla.org/en-US/docs/Web/CSS/Reference/Selectors/:is)

## css layers

determines priorities without using the important hack, however note from MDN that styles that are not defined in a layer always override styles declared in named and anonymous layers.

```css
@layer base, components, utilities;
@layer utilities {
  .mt-4 { margin-top: 1rem; }
}
```

> A rule in utilities would be applied even if it has lower specificity than the rule in components. This is because once the layer order has been established, specificity and order of appearance are ignored. This enables using simpler CSS selectors because you do not have to ensure that a selector will have high enough specificity to override competing rules; all you need to ensure is that it appears in a later layer.

[MDN page](https://developer.mozilla.org/en-US/docs/Web/CSS/Reference/At-rules/@layer)

Use with import to create a base layer which any non layered css then automatically overrides

```css
@import "reset.css" layer(reset);
```

## css custom properties

> Sass and LESS variables compile to static values. Custom properties live in the browser and can change at runtime.

```css
:root {
  --primary: #7c3aed;
  --spacing: 16px;
}
.btn { background: var(--primary); }
```

## aspect ratio

```css
.video-wrapper {
  aspect-ratio: 16 / 9;
}
```

## place a child item in centre of parent

```css
.parent {
  display: grid;
  place-items: center;
}
// no styling on child
```

## Links

- [Modern CSS](https://modern-css.com/?baseline=widely)
- [In Real Life](https://chriscoyier.net/2023/06/06/modern-css-in-real-life/)
- [Example modern reset](https://frontendmasters.com/blog/the-coyier-css-starter/#the-whole-thing)
- [Skill](https://skills.sh/paulirish/dotfiles/modern-css)
- [Guides](https://css-tricks.com/guides/)