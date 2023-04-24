Keycloak integration With ACT complaint management system in PHP 

how to set keycloak by using the standalone and application implmentation with php language
Test Running Application



Step 1: Keycloak Setup

The first step is to use the keycloak admin console to manage client registration and set role permissions.

Open with your favorite browser like Chrome or Mozilla

    http://localhost:8280/auth

login with username and password :

username: shime
password: 1212

Create New Realm in Keycloak

Follow steps below:

    Click Add realm button on the top left of the admin dashboard. Create a new realm with this data:
        Name = demo-realm
    Click Create
    Click Login tab, then configure this value:
        User registration = ON
    Click Save

Create New Client in Keycloak

Follow steps below:

    Click on Clients in the left menu
    Click on "Create", then configure these values:
        Client ID = php_client
    Click Save
    Edit this field:
        Access Type = public
        Valid Redirect URIs = http://localhost/complaint/ACT_Compliant-management-system/*

Create Permission to Client

Follow steps below:

    Click on Clients in the left menu
    Click Edit button next to php_client
    Click Roles tab and click button Add Role example Role Name = access_view
    Click Mappers on tab and click button Add Builtin checklist client roles and click save
    Click edit client roles in Token Claim Name change roles to permission and click save

Now you have successfully finished the keycloak configuration for the new client application.
Roles and Permission

Follow steps below:

    Click on Roles in the left menu
    Click Add Role Example :

    Name = Administrator
    Set Composite Roles = ON
    in Composite Roles Select Client Roles php_client
    in Alvailable Roles select permission access_view and click Add selected
    click tab Default Roles in top Roles page
    in Realm Roles select Available Roles Administrator example for default roles user register app

Get Keycloak JSON setup for app

Follow steps below:

    Click on Clients in the left menu
    Click php_client
    Click on Installation in top menu
    in Format Option select a format Keycloak OIDC JSON and click Download
    move keycloak.json in the root folder app

Setup keycloak.json in app PHP

move keycloak.json to root app directory PHP create file index.php and add code like this

<script src="http://localhost:2080/auth/js/keycloak.js"></script>
<script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>
<script type="text/javascript">
    const keycloak = Keycloak('http://localhost:3000/keycloak.json')
    const initOptions = {
        responseMode: 'fragment',
        flow: 'standard',
        onLoad: 'login-required'
    };
    function logout(){
        Cookies.remove('token');
        Cookies.remove('callback');
        keycloak.logout();
    }
    keycloak.init(initOptions).success(function(authenticated) {
        Cookies.set('token', keycloak.token);
        Cookies.set('callback',JSON.stringify(keycloak.tokenParsed.resource_access.php_service.permission));
        var arr = JSON.parse(Cookies.get('callback'));
        arr = arr.reduce((index,value) => (index[value] = true, index), {});
        (arr.access_create === true ? document.getElementById("create").disabled = false : document.getElementById("create").disabled = true);
        (arr.access_edit === true ? document.getElementById("edit").disabled = false : document.getElementById("edit").disabled = true);
        (arr.access_delete === true ? document.getElementById("delete").disabled = false : document.getElementById("delete").disabled = true);
        (arr.access_view === true ? document.getElementById("read").disabled = false : document.getElementById("read").disabled = true);
        document.getElementById("test").innerHTML = Cookies.get('token');
        // console.log('Init Success (' + (authenticated ? 'Authenticated token : '+JSON.stringify(keycloak) : 'Not Authenticated') + ')');
    }).error(function() {
        console.log('Init Error');
    });
</script>

Testing User Self-Registration

Please start in Firefox or chrome a "New Private Window" and connect to the following URL

http://localhost:8280/auth/realms/demo-realm/account

Follow steps below:

    Click register in the bottom login page
