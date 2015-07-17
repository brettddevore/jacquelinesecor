jQuery(document).ready(function($) {
    var meta_image_frame;
    jQuery(".art").on("click", ".upload-image", function(e) {
        e.preventDefault();
        var $this = $(e.target) || "";
        if (meta_image_frame) {
            meta_image_frame.open();
            return;
        }
        meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
            title: meta_image.title,
            button: {
                text: meta_image.button
            },
            library: {
                type: "image"
            }
        });
        meta_image_frame.on("select", function() {
            var media_attachment = meta_image_frame.state().get("selection").first().toJSON();
            $this.prev().find("input").val(media_attachment.filename);
        });
        meta_image_frame.open();

    });
});