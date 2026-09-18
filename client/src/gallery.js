import PhotoSwipeLightbox from 'photoswipe/lightbox';

document.querySelectorAll('[data-pswp-gallery]').forEach((gallery) => {
  const lightbox = new PhotoSwipeLightbox({
    gallery,
    children: 'a',
    pswpModule: () => import('photoswipe'),
  });

  lightbox.init();
});
