document.addEventListener('DOMContentLoaded', function () {
    bsCustomFileInput.init();

    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('keyup', function () {
        slugInput.value = slugify(this.value, {
            lower: true,
            strict: true
        });
    });
});
