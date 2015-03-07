<?php
return array(
    "base_url" => "http://incuba.local/sistema/fblogin/auth",
    "providers" => array (
        "Facebook" => array (
            "enabled" => true,
            "keys" => array ( "id" => "380109965514575", "secret" => "8eaa61fdd4de66201708320ce065e627" ),
            "scope" => "public_profile,email", // optional
            "display" => "popup" // optional
        )
    )
);
