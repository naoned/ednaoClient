<?php
    $socle = isset($_GET['socle']) ? $_GET['socle'] : 'inao';
    $product = isset($_GET['product']) ? $_GET['product'] : 'archives';
    $group = isset($_GET['group']) ? $_GET['group'] : 'group_archivistes';
    $accesslevel = isset($_GET['accesslevel']) ? $_GET['accesslevel'] : 'admin';
    $version = isset($_GET['version']) ? $_GET['version'] : '3.12.1';
    $page = isset($_GET['page']) ? $_GET['page'] : 'classement';
    $url = isset($_GET['url']) ? urldecode($_GET['url']) : 'http://vbeauvivre.insitu.help.mnesys.fr';
?>

<html>
    <body>
        <h1>
            This is a dummy Naoned application
        </h1>
        <form>
            <div>
                <label>Socle</label>
                <select name="socle">
                  <option value="inao" <?php if ($socle == 'inao') : ?>selected<?php endif; ?> > iNao</option>
                  <option value="vanao" <?php if ($socle == 'vanao') : ?>selected<?php endif; ?> > vaNao</option>
                  <option value="upnao" <?php if ($socle == 'upnao') : ?>selected<?php endif; ?> > upnao</option>
                </select>
            </div>
            <div>
                <label>Produit</label>
                <select name="product">
                    <option value="archives" <?php if ($product == 'archives') : ?> selected<?php endif; ?> >archives (iNao)</option>
                    <option value="biblio" <?php if ($product == 'biblio') : ?> selected<?php endif; ?> >biblio (iNao)</option>
                    <option value="heritage" <?php if ($product == 'heritage') : ?> selected<?php endif; ?> >heritage (iNao)</option>
                    <option value="musee" <?php if ($product == 'musee') : ?> selected<?php endif; ?> >musee (iNao)</option>
                    <option value="axecio" <?php if ($product == 'axecio') : ?> selected<?php endif; ?> >axecio (iNao)</option>
                    <option value="seisan_public" <?php if ($product == 'seisan_public') : ?> selected<?php endif; ?> >seisan_public (iNao)</option>
                    <option value="seisan_privee" <?php if ($product == 'seisan_privee') : ?> selected<?php endif; ?> >seisan_privee (iNao)</option>
                    <option value="portail_valorisation" <?php if ($product == 'portail_valorisation') : ?> selected<?php endif; ?> >portail_valorisation (vaNao)</option>
                    <option value="sgm" <?php if ($product == 'sgm') : ?> selected<?php endif; ?> >sgm (upNao)</option>
                </select>
            </div>
            <div>
                <label>Groupe</label>
                <input type="text" name="group" value="<?php echo $group ?>" />
            </div>
            <div>
                <label>Droits</label>
                <select name="accesslevel">
                    <option value="admin" <?php if ($accesslevel == 'admin') : ?>selected<?php endif; ?> > admin (iNao)</option>
                    <option value="writer" <?php if ($accesslevel == 'writer') : ?>selected<?php endif; ?> > writer (iNao)</option>
                    <option value="reader" <?php if ($accesslevel == 'reader') : ?>selected<?php endif; ?> > reader (iNao)</option>
                    <option value="responsible" <?php if ($accesslevel == 'responsible') : ?>selected<?php endif; ?> > responsible (upNao)</option>
                    <option value="creator" <?php if ($accesslevel == 'creator') : ?>selected<?php endif; ?> > creator (upNao)</option>
                    <option value="editor" <?php if ($accesslevel == 'editor') : ?>selected<?php endif; ?> > editor (upNao)</option>
                    <option value="reader" <?php if ($accesslevel == 'reader') : ?>selected<?php endif; ?> > reader (upNao)</option>
                    <option value="visitor" <?php if ($accesslevel == 'visitor') : ?>selected<?php endif; ?> > visitor (upNao)</option>
                    <option value="admin" <?php if ($accesslevel == 'admin') : ?>selected<?php endif; ?> > admin (vaNao)</option>
                    <option value="editor" <?php if ($accesslevel == 'editor') : ?>selected<?php endif; ?> > editor (vaNao)</option>
                    <option value="visitor" <?php if ($accesslevel == 'visitor') : ?>selected<?php endif; ?> > visitor (vaNao)</option>
                </select>
            </div>
            <div>
                <label>Version</label>
                <input type="text" name="version" value="<?php echo $version ?>" />
            </div>
            <div>
                <label>Page</label>
                <input id="page" type="text" name="page" value="<?php echo $page ?>" />
                <button id="apply-page" type="button" onclick="ednaoManager.goToContext(document.getElementById('page').getAttribute('value'))">Appliquer en ajax</button>
            </div>
            <div>
                <label>URL de l’aide</label>
                <input type="text" name="url" value="<?php echo $url ?>" />
            </div>
            <button type="submit">Appliquer au chargement complet</button>
        </form>
        <br />
        <?php require_once '../../../../vendor/autoload.php' ?>
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
        <script type="text/javascript" src="js/ednaoManager.js"></script>
    </body>
</html>