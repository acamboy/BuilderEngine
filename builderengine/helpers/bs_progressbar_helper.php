<?php
if ( ! function_exists('get_progress')) {
    function get_progress($payload = 0)
    {
        return '<div class="progress">'.
            '<div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow="'. $payload. '" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: '. $payload .'%;">'.
                $payload.'%'.
            '</div>'.
        '</div>';
    }
}
/*
 * End of file bs_progressbar_helper.php
 * */