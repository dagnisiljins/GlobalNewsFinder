<?php

return [
    ['GET', '/', ['App\Controllers\MainController', 'index']],
    ['GET', '/search', ['App\Controllers\MainController', 'search']]
];