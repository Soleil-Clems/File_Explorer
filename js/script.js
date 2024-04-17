$(document).ready(function () {
    let next = $("#next")
    let previous = $("#previous")
    const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'];
    const videoExtensions = ['mp4', 'avi', 'mkv', 'mov', 'wmv', 'flv'];

    const icons = {
        "folder": "<i class='fa-solid fa-folder'></i>",
        "txt": "<i class='fa-regular fa-file'></i>",
        "png": "<i class='fa-solid fa-file-image'></i>",
        "jpg": "<i class='fa-regular fa-file-image'></i>",
        "jpeg": "<i class='fa-regular fa-file-image'></i>",
        "php": "<i class='fa-brands fa-php'></i>",
        "css": "<i class='fa-brands fa-css3-alt'></i>",
        "html": "<i class='fa-brands fa-html5'></i>",
        "js": "<i class='fa-brands fa-js'></i>",
        "mp4": "<i class='fa-solid fa-file-video'></i>",
        "pdf": "<i class='fa-solid fa-file-pdf'></i>",
        "default": "<i class='fa-solid fa-code'></i>",
        "webp": "<i class='fa-solid fa-globe'></i>"
    };


    $(".folder-crumb").each(function () {
        $(this).on("click", () => {
            let folderPath = $(this).data('path');
            let fileList = $(this).closest('.file-list-side')
            let isDown = $(this).data('down');
            if (isDown) {
                $(this).removeClass('fa-caret-down').addClass('fa-caret-right');
            } else {
                $(this).removeClass('fa-caret-right').addClass('fa-caret-down');
            }

            $.fn.handleClick(folderPath, fileList, isDown)

            $(this).data('down', !isDown);

        });
    })

    $.fn.handleClick = (folderPath, fileList, isDown) => {

        if (isDown) {
            fileList.find('.file-list-side').remove();
            fileList.find('.file').remove();

        } else {


            $.ajax({
                url: "http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/",
                type: 'POST',
                data: { folder: folderPath },
                success: function (response) {


                    $.each(response.message, function (key, path) {
                        let div = $(`<div class="file"></div>`)
                        let line = $(`<div class="line"></div>`)
                        let i = ''
                        if (path[3] == "folder") {
                            div = $(`<div class="file-list-side"></div>`)
                            i = $(`<i class="fa-solid fa-caret-right folder" data-down=false data-path="${"/" + path[0]}"></i>`)

                            i.on("click", function () {
                                let isDown = $(this).data('down');
                                let path = $(this).data('path');

                                if (isDown) {
                                    $(this).removeClass('fa-caret-down').addClass('fa-caret-right');
                                } else {
                                    $(this).removeClass('fa-caret-right').addClass('fa-caret-down');
                                }
                                $.fn.handleClick(path, div, isDown);
                                $(this).data('down', !isDown);
                            });

                        }
                        let a = "";
                        if (path[3] === "folder") {
                            a = $(`<a class=""  href="${"/" + path[0]}">${icons[path[3]] ? icons[path[3]] : icons["default"]} ${key}</a>`)
                        } else {
                            a = $(`<span class="folder fileClick" data-path=="${"/" + path[0]}">${icons[path[3]] ? icons[path[3]] : icons["default"]} ${key}</span>`)
                        }
                        line.append(i);
                        line.append(a);
                        div.append(line);
                        fileList.append(div);

                        $(a).on("click", () => {
                            let folderPath = "/" + path[0];
                            let ext = folderPath.substring(folderPath.lastIndexOf('.') + 1);
                            $("#screen").empty()

                            let folder = folderPath.split("/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/")[1];

                            if (imageExtensions.includes(ext)) {
                                let img = $(`<img src='${folderPath}' class="img">`)
                                $('#screen').append(img);
                            } else if (videoExtensions.includes(ext)) {
                                let vid = $(`<video src="${folderPath}" class='img' height="250" controls></video>`)
                                $('#screen').append(vid);
                            } else if (ext == "pdf") {
                                let vid = $(`<embed src="${folderPath}" type="application/pdf" class='img' >`)
                                $('#screen').append(vid);
                            } else {

                                $.ajax({
                                    url: "http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/preview",
                                    type: 'POST',
                                    data: { folder: folder },
                                    success: function (response) {

                                        if (response.success) {
                                            let htmlContent = response.message[0];

                                            let formattedHtml = $('<code>').addClass(`language-${response.message[1]}`).text(htmlContent);
                                            let pre = $('<pre>').append(formattedHtml);
                                            $('#screen').html(pre);

                                            Prism.highlightAll();




                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            }
                            $(".close").css({ "display": "flex" })

                        });


                    });
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        }
    }


    next.on("click", function () {
        window.history.forward();
    });

    previous.on("click", function () {
        window.history.back()
    });

    $("#select").on("change", function () {
        var selectedValue = $(this).val();

        $.ajax({
            url: "http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/filter",
            type: 'POST',
            data: { filtre: selectedValue },
            success: function (response) {

                if (response.success) {
                    location.reload();
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });


    });

    let checkedFolders = []
    $(".checkbox").on("change", function () {
        checkedFolders = [];

        $(".checkbox:checked").each(function () {
            let folderPath = [$(this).data('path'), $(this).data('ext')];
            checkedFolders.push(folderPath);
        });

        if (checkedFolders.length > 0) {
            $(".after-select").css({ "display": "inline" });
        } else {
            $(".after-select").css({ "display": "none" });

        }

        
    });

    $("#tag").on("change", function () {

        $.ajax({
            url: "http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/tag",
            type: 'POST',
            data: { folder: checkedFolders, tag: $(this).val() },
            success: function (response) {

                if (response.success) {

                    $(".checkbox:checked").each(function () {

                        $(this).prop('checked', false);
                    });
                    location.reload();
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });
    });

    $("#color").on("change", function () {
        $.ajax({
            url: "http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/color",
            type: 'POST',
            data: { folder: checkedFolders, color: $(this).val() },
            success: function (response) {

                if (response.success) {

                    $(".checkbox:checked").each(function () {

                        $(this).prop('checked', false);
                    });
                    location.reload();
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

    });

    $(".fileClick").each(function () {
        $(this).on("click", () => {
            let folderPath = $(this).data('path');
            let ext = folderPath.substring(folderPath.lastIndexOf('.') + 1);
            $("#screen").empty()

            let folder = folderPath.split("/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/")[1];

            if (imageExtensions.includes(ext)) {
                let img = $(`<img src='${folderPath}' class="img">`)
                $('#screen').append(img);
            } else if (videoExtensions.includes(ext)) {
                let vid = $(`<video src="${folderPath}" class='img' height="250" controls></video>`)
                $('#screen').append(vid);
            } else if (ext == "pdf") {
                let vid = $(`<embed src="${folderPath}" type="application/pdf" class='img' >`)
                $('#screen').append(vid);
            } else {

                $.ajax({
                    url: "http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/preview",
                    type: 'POST',
                    data: { folder: folder },
                    success: function (response) {

                        if (response.success) {

                            let htmlContent = response.message[0];

                            let formattedHtml = $('<code>').addClass(`language-${response.message[1]}`).text(htmlContent);
                            let pre = $('<pre>').append(formattedHtml);
                            $('#screen').html(pre);

                            Prism.highlightAll();




                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            }
            $(".close").css({ "display": "flex" })

        });
    })

    $(".close").on("click", () => {
        $("#screen").empty()
        $(".close").css({ "display": "none" })
    })

    $(".tagPage").each(function () {
        $(this).on("click", () => {
            let tag = $(this).data('tag')
            
            $.ajax({
                url: "http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/gettag",
                type: 'POST',
                data: { tag: tag},
                success: function (response) {

                    if (response.success) {

                        $(".foldList").empty()
                        
                        $.each(response.message, function (key, path) {
                            let a='';
                            let fileName = path.path.split("/").pop()
                            if (path.ext === "folder") {
                                a = $(`<a class=""  href="${path.path}">${icons[path.ext] ? icons[path.ext] : icons["default"]} ${fileName}</a>`)
                            } else {
                                a = $(`<span class="folder fileClick" data-path=="${path.path}">${icons[path.ext] ? icons[path.ext] : icons["default"]} ${fileName}</span>`)
                            }
                            $(".foldList").append(a)
                            $(a).on("click", () => {
                                let folderPath = "/" + path.path;
                                let ext =path.ext;
                                $("#screen").empty()
    
                                let folder = path.path.split("/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/")[1];
    
                                if (imageExtensions.includes(ext)) {
                                    let img = $(`<img src='${folderPath}' class="img">`)
                                    $('#screen').append(img);
                                } else if (videoExtensions.includes(ext)) {
                                    let vid = $(`<video src="${folderPath}" class='img' height="250" controls></video>`)
                                    $('#screen').append(vid);
                                } else if (ext == "pdf") {
                                    let vid = $(`<embed src="${folderPath}" type="application/pdf" class='img' >`)
                                    $('#screen').append(vid);
                                } else {
    
                                    $.ajax({
                                        url: "http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/preview",
                                        type: 'POST',
                                        data: { folder: folder },
                                        success: function (response) {
    
                                            if (response.success) {
                                                
                                                let htmlContent = response.message[0];
    
                                                let formattedHtml = $('<code>').addClass(`language-${response.message[1]}`).text(htmlContent);
                                                let pre = $('<pre>').append(formattedHtml);
                                                $('#screen').html(pre);
    
                                                Prism.highlightAll();
    
    
    
    
                                            }
                                        },
                                        error: function (xhr, status, error) {
                                            console.error(error);
                                        }
                                    });
                                }
                                $(".close").css({ "display": "flex" })
    
                            });
                        })

                    }
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        })
    })

    $("#search").on("input", function () {
        let val = $(this).val()
        let url = window.location.href;
        let parts = url.split("/");
        let folder = parts[4];

        $.ajax({
            url: "http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/elasticsearch",
            type: 'POST',
            data: { search: val, folder:folder },
            success: function (response) {

                if (response.success) {
                    $(".foldList").empty()
                        
                    $.each(response.message, function (key, path) {
                        let a='';
                        let fileName = path[4]
                        if (path[3] === "folder") {
                            a = $(`<a class=""  href="${path[0]}">${icons[path[3]] ? icons[path[3]] : icons["default"]} ${fileName}</a>`)
                        } else {
                            a = $(`<span class="folder fileClick"  data-path=="${path[0]}">${icons[path[3]] ? icons[path[3]] : icons["default"]} ${fileName}</span>`)
                        }

                        $(".foldList").append(a)
                        $(a).on("click", () => {
                            let folderPath = "/" + path[0];
                            let ext =path[3];
                            $("#screen").empty()

                            let folder = path[0].split("W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/")[1];

                            if (imageExtensions.includes(ext)) {
                                let img = $(`<img src='${folderPath}' class="img">`)
                                $('#screen').append(img);
                            } else if (videoExtensions.includes(ext)) {
                                let vid = $(`<video src="${folderPath}" class='img' height="250" controls></video>`)
                                $('#screen').append(vid);
                            } else if (ext == "pdf") {
                                let vid = $(`<embed src="${folderPath}" type="application/pdf" class='img' >`)
                                $('#screen').append(vid);
                            } else {

                                $.ajax({
                                    url: "http://localhost/W-PHP-501-MAR-1-1-myh5ai-adonai.ouisol/preview",
                                    type: 'POST',
                                    data: { folder: folder },
                                    success: function (response) {

                                        if (response.success) {
                                            
                                            let htmlContent = response.message[0];

                                            let formattedHtml = $('<code>').addClass(`language-${response.message[1]}`).text(htmlContent);
                                            let pre = $('<pre>').append(formattedHtml);
                                            $('#screen').html(pre);

                                            Prism.highlightAll();


                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        console.error(error);
                                    }
                                });
                            }
                            $(".close").css({ "display": "flex" })

                        });
                    })

                }
            },
            error: function (xhr, status, error) {
                console.error(error);
            }
        });

    });

});
