jQuery(document).ready(function ($) {

    //Change le lien du logo
    $('body.login #login h1 a').attr('href', './');
    $('body.login h1 a').attr('target', '_blank');
    $('body.login h1').addClass('logo-client');



    // Créer et ajouter une div avant la div #login dans body.login
    // $('<div>').addClass('login-custom-div1').prependTo('body.login');

    // Créer et ajouter une div après la div #login dans body.login
    //$('<div>').addClass('login-custom-div2').insertAfter('body.login #login');



});
