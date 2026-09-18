<section class="photoswipe-gallery-element">
    <% if $Title && $ShowTitle %>
        <h2>$Title</h2>
    <% end_if %>

    <% if $SortedGalleryImages.Exists %>
        <% include DorsetDigital\SilverstripePhotoswipe\Includes\Gallery %>
    <% end_if %>
</section>
