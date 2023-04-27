var keycloak = new Keycloak();

function initKeycloak() {
    keycloak.init({onLoad: 'login-required'}).then(function() {

    }).catch(function() {
        alert('failed to initialize');
    });
}



var logout = function() {
  keycloak.logout({});
}