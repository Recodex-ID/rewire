{{-- Spam trap, checked by App\Http\Middleware\RejectSpamSubmissions. Off-screen rather than display:none because bots skip hidden fields more often than moved ones. --}}
<div aria-hidden="true" style="position: absolute; left: -10000px; top: auto; width: 1px; height: 1px; overflow: hidden;">
    <label>
        Leave this field empty
        <input type="text" name="{{ \App\Http\Middleware\RejectSpamSubmissions::HONEYPOT_FIELD }}" value="" tabindex="-1" autocomplete="off">
    </label>
</div>
