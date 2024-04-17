<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/assets/favicon.png" type="image/x-icon">
    <title>My H5AI</title>
    <link rel="stylesheet" href="http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/themes/prism.min.css">

</head>

<body>
    <header>
        <div class="header-left">
            <form action="" method="post">
                <input type="search" id="search" name="search" placeholder="Elastic search">
                <label for="search"><i class="fa-brands fa-searchengin"></i></label>
            </form>
        </div>
        <div class="header-right">
            <div class="tagPage" data-tag="<?= $tags[0]['name'] ?>"><?= $tags[0]['name'] ?></div>
            <div class="tagPage" data-tag="<?= $tags[1]['name'] ?>"><?= $tags[1]['name'] ?></div>
            <div class="tagPage" data-tag="<?= $tags[2]['name'] ?>"><?= $tags[2]['name'] ?></div>
            <div class="tagPage" data-tag="<?= $tags[3]['name'] ?>"><?= $tags[3]['name'] ?></div>
            <div class="tagPage" data-tag="<?= $tags[4]['name'] ?>"><?= $tags[4]['name'] ?></div>
        </div>

    </header>
    <div class=" container">
        <div class="col col-1">
            <div class="row row1">
                <i class="fa-regular fa-circle-left" id="previous" data-path=""></i>
                <i class="fa-regular fa-circle-right" id="next" data-path=""></i>
            </div>
            <div class="file-container">

                <div class="file-list-side">
                    <div class="line">
                        <i class="fa-solid fa-caret-right folder-crumb " data-path=<?= $parentPath ?>></i>
                        <a class="" href=<?= "/" . $parentPath ?>><?= $icons["folder"] . " " . $parent ?></a>

                    </div>

                </div>

            </div>
        </div>

        <div class="col col-2">
            <div class="row row1 row-pwd">
                <div class="pwd"> <?= $folder ?></div>
                <div class="filter">
                    <form action="" method="post">

                        <select name="tags" id="tag" class="after-select">
                            <option>Choose Tag</option>
                            <?php
                            foreach ($tags as $key => $tag) { ?>
                                <option value=<?= $tag['name'] ?>><?= $tag['name'] ?></option>
                            <?php } ?>
                        </select>
                        <select name="colors" id="color" class="after-select">
                            <option>Choose Color</option>
                            <?php
                            foreach ($colors as $key => $color) { ?>
                                <option style="padding:1em; background:<?= $color['color'] ?>; color:white;" value=<?= $color['color'] ?>><?= $color['color_name'] ?></option>
                            <?php } ?>
                        </select>
                        <select name="filter" id="select">
                            <option><?= $filters[$actual - 1]['filter'] ?></option>
                            <?php
                            foreach ($filters as $key => $filter) { ?>
                                <option value=<?= $filter['id'] ?>><?= $filter['filter'] ?></option>
                            <?php } ?>

                        </select>
                    </form>
                </div>
            </div>

            <div class="row row2">

                <div class="file-list foldList">

                    <?php
                    foreach ($arr as $key => $value) {
                        $setColor = "/$value[0]";
                        $theColor = '';
                        if (in_array($setColor, array_keys($coloredIcon))) {
                            $theColor = $coloredIcon[$setColor];
                        } else {
                            $theColor = "";
                        }
                    ?>

                        <div class="file-list">
                            <input type="checkbox" data-path="/<?= $value[0] ?>" data-ext="<?= $value[3] ?>" name="check" class="checkbox">
                            <?php
                            if ($value[3] == "folder") { ?>
                                <a class="folder" href="/<?= $value[0] ?>" data-ext="<?= $value[3] ?>">
                                    <span>
                                        <?= iconFunc($value[3], $theColor) ?> <?= $key ?>
                                    </span>
                                    <span>

                                    </span>

                                </a>

                            <?php } else { ?>
                                <span class="folder fileClick" data-ext="<?= $value[3] ?>" data-path="/<?= $value[0] ?>">
                                    <span>
                                        <?= iconFunc($value[3], $theColor) ?> <?= $key ?>
                                    </span>
                                    <span class="size">
                                        <?= $value[1] ?>octets
                                    </span>
                                    <span class="time">
                                        <?= $value[2] ?>
                                    </span>
                                </span>
                            <?php } ?>

                        </div>

                    <?php } ?>


                </div>

                <div class="screen">
                    <div class="close"><i class="fa-solid fa-rectangle-xmark"></i></div>
                    <div id="screen"></div>
                </div>

            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/plugins/autoloader/prism-autoloader.min.js"></script>
    <script>
        Prism.highlightAll();
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/js/script.js"></script>
</body>

</html>