<?php

use Laravel\Dusk\Browser;

it('can visit the home page', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->assertSee('XPTrackr');
    });
});

it('has proper page title', function () {
    $this->browse(function (Browser $browser) {
        $browser->visit('/')
                ->assertTitle('Laravel');
    });
});
