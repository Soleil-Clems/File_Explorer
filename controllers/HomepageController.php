<?php

include "./models/FilterModel.php";
include "./models/ColorsModel.php";
include "./models/TagsModel.php";

class HomepageController
{
    private $paths = [];

    public function __construct()
    {
    }

    public function getHomepage()
    {
        $filterModel = new FilterModel();
        $filters = $filterModel->getFilterModel();
        $actual = $filterModel->actualFiltreModel();

        $colorModel = new ColorsModel();
        $colors = $colorModel->getColorsModel();
        $coloredIcon = $colorModel->getIconModel();
        $tagModel = new TagsModel();
        $tags = $tagModel->getTagsModel();

        $server = explode("/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/", $_SERVER['REQUEST_URI']);
        $folder = end($server);
        $parent = explode("/", $folder)[0];

        if ($folder == "") {
            $folder = "myh5ai";
            $parent = "myh5ai";
        }

        $pathFolder = "W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/" . $folder;
        $parentPath = "W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/" . $parent;

        $icons = [
            "folder" => "<i class='fa-solid fa-folder'></i>",
            "txt" => "<i class='fa-regular fa-file'></i>",
            "png" => "<i class='fa-solid fa-file-image'></i>",
            "jpg" => "<i class='fa-regular fa-file-image'></i>",
            "jpeg" => "<i class='fa-regular fa-file-image'></i>",
            "php" => "<i class='fa-brands fa-php'></i>",
            "css" => "<i class='fa-brands fa-css3-alt'></i>",
            "html" => "<i class='fa-brands fa-html5'></i>",
            "js" => "<i class='fa-brands fa-js'></i>",
            "default" => "<i class='fa-solid fa-code'></i>",
            "webp" => "<i class=fa-solid fa-globe'></i>",
        ];

        function iconFunc($key, $color = "")
        {

            switch ($key) {
                case "folder":
                    echo "<i class='fa-solid fa-folder' style='color:$color'></i>";
                    break;
                case "txt":
                    echo "<i class='fa-regular fa-file' style='color:$color'></i>";
                    break;
                case "png":
                    echo "<i class='fa-solid fa-file-image' style='color:$color'></i>";
                    break;
                case "jpg":
                case "jpeg":
                    echo "<i class='fa-regular fa-file-image' style='color:$color'></i>";
                    break;
                case "php":
                    echo "<i class='fa-brands fa-php' style='color:$color'></i>";
                    break;
                case "css":
                    echo "<i class='fa-brands fa-css3-alt' style='color:$color'></i>";
                    break;
                case "html":
                    echo "<i class='fa-brands fa-html5' style='color:$color'></i>";
                    break;
                case "mp4":
                    echo "<i class='fa-solid fa-file-video' style='color:$color'></i>";
                    break;
                case "pdf":
                    echo "<i class='fa-solid fa-file-pdf' style='color:$color'></i>";
                    break;
                case "js":
                    echo "<i class='fa-brands fa-js' style='color:$color'></i>";
                    break;
                case "webp":
                    echo "<i class='fa-solid fa-globe' style='color:$color'></i>";
                    break;
                default:
                    echo "<i class='fa-solid fa-code' style='color:$color'></i>";
                    break;
            }
        }

        $arr = $this->glob_recursive($folder, $actual);
        include(__DIR__ . '/../views/homepage.php');
    }

    public function getFolder()
    {
        $server = explode("W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/", $_POST["folder"]);
        $folder = end($server);
        $arr = $this->glob_recursive($folder);
        header('Content-Type: application/json');
        echo json_encode(array("success" => true, "message" => $arr));
    }

    public function glob_recursive($folder, $sort_by = '1')
    {
        $files = glob("$folder/*");

        foreach ($files as $file) {
            $filename = basename($file);
            if ($filename == '.' || $filename == '..') {
                continue;
            }

            if (is_dir($file)) {
                $folderName = $filename;
                $folderFullPath = "W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/" . $file;
                $path = str_replace("//", "/", $folderFullPath);
                $lastTime = filemtime($file);
                $lastUpdate = date('Y-m-d H:i:s', $lastTime);
                $size = filesize($file);

                $this->paths[$folderName] = [$path, $size, $lastUpdate, "folder"];
            } else {
                $folderName = $filename;
                $folderFullPath = "W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/" . $file;
                $path = str_replace("//", "/", $folderFullPath);
                $lastTime = filemtime($file);
                $fileType = pathinfo($file)['extension'];
                $lastUpdate = date('Y-m-d H:i:s', $lastTime);
                $size = filesize($file);

                $this->paths[$folderName] = [$path, $size, $lastUpdate, $fileType];
            }
        }


        switch ($sort_by) {
            case '1':
                uksort($this->paths, function ($a, $b) {
                    return strcasecmp($a, $b);
                });
                break;
            case '2':
                uksort($this->paths, function ($a, $b) {
                    return strcasecmp($b, $a);
                });
                break;
            case '3':
                uasort($this->paths, function ($a, $b) {
                    return $a[1] - $b[1];
                });
                break;
            case '4':
                uasort($this->paths, function ($a, $b) {
                    return $b[1] - $a[1];
                });
                break;
            case '5':
                uasort($this->paths, function ($a, $b) {
                    return strtotime($a[2]) - strtotime($b[2]);
                });
                break;
            case '6':
                uasort($this->paths, function ($a, $b) {
                    return strtotime($b[2]) - strtotime($a[2]);
                });
                break;
            case '7':
                uasort($this->paths, function ($a, $b) {
                    if ($a[2] == $b[2]) {
                        if ($a[1] == $b[1]) {
                            return strcasecmp($a[0], $b[0]);
                        }
                        return ($a[1] < $b[1]) ? -1 : 1;
                    }
                    return strtotime($a[2]) - strtotime($b[2]);
                });
                break;
            case '8':
                uasort($this->paths, function ($a, $b) {
                    if ($a[2] == $b[2]) {
                        if ($a[1] == $b[1]) {
                            return strcasecmp($a[0], $b[0]);
                        }
                        return ($a[1] < $b[1]) ? -1 : 1;
                    }
                    return strtotime($a[2]) - strtotime($b[2]);
                });
            case '9':
                uasort($this->paths, function ($a, $b) {
                    if ($a[0] == $b[0]) {
                        return $a[1] - $b[1];
                    }
                    return strcmp($a[0], $b[0]);
                });
                break;
            case '10':
                uasort($this->paths, function ($a, $b) {
                    if ($a[1] == $b[1]) {
                        return strtotime($a[2]) - strtotime($b[2]);
                    }
                    return $a[1] - $b[1];
                });
                break;
            case '11':
                uasort($this->paths, function ($a, $b) {
                    if ($a[2] == $b[2]) {
                        return strcmp($a[0], $b[0]);
                    }
                    return strtotime($a[2]) - strtotime($b[2]);
                });
                break;

            default:
                uksort($this->paths, function ($a, $b) {
                    return strcasecmp($a, $b);
                });
                break;
        }

        return $this->paths;
    }

    public function setFilterController()
    {
        if (isset($_POST['filtre']) && !empty($_POST['filtre'])) {
            $filtre = filter_var($_POST['filtre'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        $filterModel = new FilterModel();
        $fil = $filterModel->setFilterModel($filtre);
        header('Content-Type: application/json');
        echo json_encode(array("success" => $fil[0], "message" => $fil[1]));
    }

    public function setColorController()
    {
        if (isset($_POST['color'], $_POST['folder']) && !empty($_POST['folder']) && !empty($_POST['color'])) {
            $color = $_POST['color'];
            $folders = $_POST['folder'];
        }
        $colorModel = new ColorsModel();
        $col = $colorModel->setColorsModel($color, $folders);
        header('Content-Type: application/json');
        echo json_encode(array("success" => true, "message" => $col));
    }

    public function setTagController()
    {
        if (isset($_POST['tag'], $_POST['folder']) && !empty($_POST['folder']) && !empty($_POST['tag'])) {
            $tag = $_POST['tag'];
            $folders = $_POST['folder'];
        }
        $tagModel = new TagsModel();
        $tag = $tagModel->setTagModel($tag, $folders);
        header('Content-Type: application/json');
        echo json_encode(array("success" => true, "message" => $tag));
    }

    public function getTagController()
    {
        if (isset($_POST['tag'])  && !empty($_POST['tag'])) {
            $tag = $_POST['tag'];
        }
        $tagModel = new TagsModel();
        $tag = $tagModel->getTagModel($tag);
        header('Content-Type: application/json');
        echo json_encode(array("success" => true, "message" => $tag));
    }

    public function getContentFile()
    {
        if (isset($_POST['folder'])) {
            $folder = $_POST['folder'];
            $content = file_get_contents($folder);
            $ext = pathinfo($folder)['extension'];
            header('Content-Type: application/json');
            echo json_encode(array("success" => true, "message" => [$content, $ext]));
        }
    }

    public function glob_recursive_post($folder = "myh5ai", $search = "")
    {
        $search = $_POST["search"];
        $folder = $_POST["folder"];
        if ($folder == "") {
            $folder = "myh5ai";
        }


        $this->globfunc($folder, $search);
        header('Content-Type: application/json');
        echo json_encode(array("success" => true, "message" => $this->paths));
    }

    public function globfunc($folder, $search)
    {
        $files = glob("$folder/*");
        foreach ($files as $key => $file) {
            $filename = basename($file);
            $last_slash_pos = strrpos($file, '/');

            $second_last_slash_pos = strrpos(substr($file, 0, $last_slash_pos), '/');

            $new_file = substr($file, 0, $second_last_slash_pos + 1);
            if ($filename == '.' || $filename == '..') {
                continue;
            }

            $last = explode('/', $file);

            $phrase = end($last);

            if (is_dir($file)) {
                $folderName = $filename;
                $folderFullPath = "W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/" . $file;
                $path = str_replace("//", "/", $folderFullPath);
                $lastTime = filemtime($file);
                $lastUpdate = date('Y-m-d H:i:s', $lastTime);
                $size = filesize($file);

                if (preg_match("/" . preg_quote($search, "/") . "/", $phrase, $matches)) {
                    $this->paths[$file] = [$path, $size, $lastUpdate, "folder", $folderName];
                    // array_push($this->paths, $file);
                }

                $this->globfunc($file, $search);
            } else {
                $folderName = $filename;
                $folderFullPath = "W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/" . $file;
                $fileType = pathinfo($file)['extension'];
                $path = str_replace("//", "/", $folderFullPath);
                $lastTime = filemtime($file);
                $lastUpdate = date('Y-m-d H:i:s', $lastTime);
                $size = filesize($file);

                if (preg_match("/" . preg_quote($search, "/") . "/", $phrase, $matches)) {

                    $this->paths[$file] = [$path, $size, $lastUpdate, $fileType, $folderName];
                }
            }
        }
    }
}
