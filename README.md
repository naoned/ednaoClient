
This library is a part of ednao (inao help system) and cannot be used without it

This library is the application side o the help (iframe)

# Dummy test application
For test and review purpose, you can add a vhost to the web/ folder
    <VirtualHost *:80>
        ServerAdmin vbeauvivre@naoned.fr
        ServerName test.insitu.help.mnesys.fr
        DocumentRoot /PATH/TO/vendor/naoned/ednaoClient/web
    </VirtualHost>


# Add the iframe for a specific content
    <?php // If you do not have autoload in your app ?>
    <?php include('[…]/vendor/autoload.php') ?>
    <?php
        echo Naoned\EdnaoClient\Renderer::iframe(
            $url,
            $socle,
            $version,
            $product,
            array($group => $accesslevel),
            $page
        );
    ?>

# js lib
It is needed and helps you to interact with help iframe

Add to your markup :
    <script type="text/javascript" src="js/ednaoManager.js"></script>

Use it like that :
    <script type="text/javascript">
        ednaoManager.goToContext('classement');
        ednaoManager.show();
        ednaoManager.hide();
    </script>

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

