<figure class="photoswipe-gallery__item">
    <% with $ScaleMaxWidth(1600).Convert('webp') %>
        <a class="photoswipe-gallery__link" href="$URL" data-pswp-width="$Width" data-pswp-height="$Height">
            <% with $Up.ScaleMaxWidth(550).Convert('webp') %>
                <img class="photoswipe-gallery__image" src="$URL" width="$Width" height="$Height" loading="lazy" decoding="async" alt="$Up.Title.ATT">
            <% end_with %>
        </a>
    <% end_with %>
</figure>
