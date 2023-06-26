class Overlay
{
    constructor() {
        this.overlay = $('#overlay');
    }

    overlayShow() { this.overlay.removeClass('hide'); }
    overlayHide() { this.overlay.addClass('hide'); }
}