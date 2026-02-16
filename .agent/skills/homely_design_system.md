---
name: Homely Design System
description: Design system based on the Homely real estate theme, featuring a clean, high-end aesthetic with sage green accents and glassmorphism.
---

# Homely Design System

This skill provides the design tokens and component patterns extracted from the [Homely theme](https://madebydesignesia.com/themes/homely/).

## Design Tokens

### Colors

- **Primary:** `#B5C99A` (Sage Green)
- **Primary Hover:** `#d8f6b1`
- **Secondary (Dark):** `#092519` (Forest Green)
- **Background:** `#FCFDFD` (Off-white)
- **Text (Heading):** `#101828` (Charcoal)
- **Text (Body):** `#707070` (Grey)
- **Overlay:** `rgba(181, 201, 154, 0.5)`

### Typography

- **Font Family:** `Figtree`, sans-serif
- **Heading 1:** `72px`, Semi-bold (600)
- **Section Heading:** `48px`, Semi-bold
- **Body:** `16px`, Line-height `1.6`

### Layout

- **Max Width:** `1304px`
- **Section Padding:** `100px 0`
- **Border Radius:** `5px`

## CSS Variables Implementation

```css
:root {
  --primary-color: #b5c99a;
  --primary-hover: #d8f6b1;
  --secondary-color: #092519;
  --bg-color: #fcfdfd;
  --text-heading: #101828;
  --text-body: #707070;
  --accent-overlay: rgba(181, 201, 154, 0.5);

  --font-main: "Figtree", sans-serif;

  --container-max-width: 1304px;
  --section-padding: 100px;
  --border-radius: 5px;
  --transition: all 0.3s ease;
}

.glassmorphism {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
}
```

## Component Patterns

### Buttons

```html
<a href="#" class="btn-main">View Details</a>

<style>
  .btn-main {
    background-color: var(--primary-color);
    color: var(--secondary-color);
    padding: 12px 30px;
    border-radius: var(--border-radius);
    font-weight: 600;
    text-decoration: none;
    transition: var(--transition);
    display: inline-block;
  }
  .btn-main:hover {
    background-color: var(--primary-hover);
  }
</style>
```
