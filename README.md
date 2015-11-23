# Create a simple token

    $token = new Token(string $socle, string $product, array $rights);

Useful methods are :

    $token->getSocle(); // Get the socle
    $token->getProduct(); // Get the product
    $token->getRights(); // Get the rights (array)
    $token->serialize(); // Get the token serialized (not encoded)

# Encode a token

    $token = new Token(string $socle, string $product, array $rights);
    $ednaoCrypt = new EdnaoCryptography();
    $tokenManager = new TokenManager($ednaoCrypt);
    $encodedToken = $tokenManager->getTokenCrypt($token);

$encodedToken is a string that represents a token

# Decode a token

    $str = '...'; // An encoded token
    $ednaoCrypt = new EdnaoCryptography();
    $tokenManager = new TokenManager($ednaoCrypt);
    $token = $tokenManager->getTokenDecrypt($str);

$token is an entity of Token class

# For test and review purpose, yu can add a vhost to the web/ folder
    <VirtualHost *:80>
        ServerAdmin vbeauvivre@naoned.fr
        ServerName client.insitu.help.mnesys.fr
        DocumentRoot /PATH/TO/ednaoClient/web
    </VirtualHost>


# Add the iframe for a specific content
    <?php include('[…]/vendor/autoload.php') ?>
    <?php
        echo Naoned\EdnaoClient\Iframe::render(
            $url,
            $socle,
            $version,
            $product,
            array($group => $accesslevel),
            $page
        );
    ?>
