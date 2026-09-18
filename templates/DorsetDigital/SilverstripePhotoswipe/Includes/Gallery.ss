<% if $SortedGalleryImages.Exists %>
<div class="photoswipe-gallery" data-pswp-gallery>
    <% loop $SortedGalleryImages %>
        <% include DorsetDigital\SilverstripePhotoswipe\Includes\GalleryImage %>
    <% end_loop %>
</div>
<% end_if %>
