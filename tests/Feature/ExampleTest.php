<?php

test('the application redirects to the login page', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('auth.login'));
});
