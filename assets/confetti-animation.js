/* --- */
jQuery(document).ready(function() {
    /* --- */
    var self,
        delay,
        duration;
    /* --- */
    jQuery(".confetti-animation").each(function(i) {
        self = jQuery(this);
        delay = 1000 * parseFloat(self.attr("data-delay"));
        duration = 1000 * parseFloat(self.attr("data-duration"));
    });
    /* --- */
    if ((delay >= 50) && (delay <= 3600 * 1000) && (duration >= 50) && (duration <= 3600 * 1000)) {
        setTimeout(function() {
            confetti.start();
            setTimeout(function() {
                confetti.stop();
            }, duration);
        }, delay);
    }
});
/* --- */