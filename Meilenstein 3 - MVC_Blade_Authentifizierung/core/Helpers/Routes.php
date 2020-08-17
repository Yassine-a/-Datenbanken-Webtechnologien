<?php

Routes::set('Produkte',function (){
    homeController::CreateView();
});

Routes::set('Start',function (){
    homeController::CreateView();
    echo "jrbjr";
});