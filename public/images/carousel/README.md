# Carousel Images Upload Folder

This folder is for storing hero carousel images.

## Upload Instructions:

1. Place your carousel images here with these exact filenames:
   - `slide-1.jpg` - First carousel slide
   - `slide-2.jpg` - Second carousel slide
   - `slide-3.jpg` - Third carousel slide

2. Image Recommendations:
   - Format: JPG or PNG
   - Size: 1920x1080 pixels or larger (16:9 aspect ratio)
   - File size: 500KB - 2MB each

3. After uploading images, refresh your browser to see them in the carousel.

## Current Setup:
- Carousel auto-rotates every 5 seconds
- Next/Previous buttons to manually navigate
- Dot indicators at the bottom to jump to any slide
- 40% dark overlay for text visibility
- Fully responsive design

You can also change the slide content (badge, title, description) by editing the carousel data in `/resources/views/welcome.blade.php` in the Alpine.js carousel function.
