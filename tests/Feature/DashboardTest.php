<?php

test('guests can visit the dashboard', function () {

    $this->get('/dashboard')->assertStatus(200);
});
